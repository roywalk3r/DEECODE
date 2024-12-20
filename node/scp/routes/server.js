const express = require('express');
const bodyParser = require('body-parser');
const Stripe = require('stripe');
const cors = require('cors');
const { PrismaClient } = require('@prisma/client');
const helmet = require('helmet');
const morgan = require('morgan');
const dotenv = require('dotenv');
const Joi = require('joi');
const rateLimit = require('express-rate-limit');

dotenv.config();

const app = express();

// Configure CORS options
const corsOptions = {
    origin: 'http://localhost:5173', // Replace with your frontend's URL
    methods: ['GET', 'POST', 'PUT', 'DELETE'],
    allowedHeaders: ['Content-Type', 'Authorization'],
};

// Enable CORS middleware
app.use(cors(corsOptions));
// Check if STRIPE_SECRET_KEY is set
if (!process.env.STRIPE_SECRET_KEY) {
    console.error('STRIPE_SECRET_KEY is not set. Please set it in your environment variables.');
    process.exit(1);
}

const stripe = new Stripe(process.env.STRIPE_SECRET_KEY);
const prisma = new PrismaClient();


// Middleware
app.use(express.json());
app.use(cors());
app.use(helmet());
app.use(bodyParser.json());

app.use(express.urlencoded({ extended: false }));

app.use(express.static('public'));
app.use(morgan('combined'));

const apiLimiter = rateLimit({
    windowMs: 15 * 60 * 1000, // 15 minutes
    max: 100 // limit each IP to 100 requests per windowMs
});

app.use('/api/', apiLimiter);

const validateStudent = Joi.object({
    name: Joi.string().required(),
    email: Joi.string().email().required(),
    studentId: Joi.string().required()
});

const validatePayment = Joi.object({
    amount: Joi.number().positive().required(),
    currency: Joi.string().required(),
    studentId: Joi.string().required()
});

app.post('/api/students', async (req, res, next) => {
    try {
        const { error, value } = validateStudent.validate(req.body);
        if (error) {
            return res.status(400).json({ error: error.details[0].message });
        }

        const student = await prisma.student.create({
            data: value,
        });
        res.status(201).json(student);
    } catch (error) {
        next(error);
    }
});

app.post('/api/payments/create', async (req, res, next) => {
    try {
        const { error, value } = validatePayment.validate(req.body);
        if (error) {
            return res.status(400).json({ error: error.details[0].message });
        }

        const paymentIntent = await stripe.paymentIntents.create({

            amount: Math.round(value.amount * 100),
            currency: value.currency,
            metadata: { studentId: value.studentId },
        });
        res.status(200).json({ clientSecret: paymentIntent.client_secret });
    } catch (error) {
        next(error);
    }
});

async function handlePaymentIntentSucceeded(paymentIntent) {
    try {
        const studentId = paymentIntent.metadata.studentId;
        await prisma.payment.create({
            data: {
                studentId,
                amount: paymentIntent.amount / 100, // Convert cents to dollars
                currency: paymentIntent.currency,
                status: 'succeeded',
            },
        });
        console.log(`Payment recorded for student ${studentId}`);
    } catch (error) {
        console.error('Error handling successful payment:', error);
    }
}

app.post('/webhook', async (req, res) => {
    const sig = req.headers['stripe-signature'];
    const endpointSecret = process.env.STRIPE_WEBHOOK_SECRET;

    let event;

    try {
        event = stripe.webhooks.constructEvent(req.body, sig, endpointSecret);
    } catch (err) {
        console.error(`Webhook Error: ${err.message}`);
        return res.status(400).send(`Webhook Error: ${err.message}`);
    }

    // Handle the event
    switch (event.type) {
        case 'payment_intent.succeeded':
            const paymentIntent = event.data.object;
            console.log('PaymentIntent was successful!');
            await handlePaymentIntentSucceeded(paymentIntent);
            break;
        // ... handle other event types
        default:
            console.log(`Unhandled event type ${event.type}`);
    }

    // Return a 200 response to acknowledge receipt of the event
    res.send();
});
app.get('/api/students/:id/payments', async (req, res, next) => {
    try {
        const { id } = req.params;
        const payments = await prisma.payment.findMany({
            where: { studentId: id },
        });
        res.status(200).json(payments);
    } catch (error) {
        next(error);
    }
});

// Error handling middleware
app.use((err, req, res, next) => {
    console.error(err.stack);
    res.status(500).json({ error: 'Something went wrong!' });
});

const PORT = process.env.PORT || 5000;
app.listen(PORT, () => {
    console.log(`Server running on port ${PORT}`);
    console.log(`Stripe API key status: ${process.env.STRIPE_SECRET_KEY ? 'Set' : 'Not set'}`);
});
