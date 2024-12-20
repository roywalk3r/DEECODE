// Import necessary modules
const express = require('express');
const bodyParser = require('body-parser');
const Stripe = require('stripe');
const cors = require('cors');
const { PrismaClient } = require('@prisma/client');
const helmet = require('helmet');
const morgan = require('morgan');
const dotenv = require('dotenv');

// Load environment variables
dotenv.config();

// Initialize modules
const app = express();
const stripe = Stripe(process.env.STRIPE_SECRET_KEY); // Use environment variable for Stripe secret key
const prisma = new PrismaClient();

// Middleware
app.use(cors());
app.use(helmet()); // Add security headers
app.use(bodyParser.json());
app.use(express.raw({ type: 'application/json' })); // For Stripe webhook
app.use(express.static('public'));
app.use(morgan('combined')); // Log HTTP requests

// Routes

// 1. Create a new student record
app.post('/students', async (req, res) => {
    const { name, email, studentId } = req.body;
    try {
        const student = await prisma.student.create({
            data: { name, email, studentId },
        });
        res.status(201).json(student);
    } catch (error) {
        console.error(error);
        res.status(500).json({ error: 'Error creating student record' });
    }
});

// 2. Create a payment intent for tuition fees
app.post('/payments/create', async (req, res) => {
    const { amount, currency, studentId } = req.body;
    if (!amount || !currency || !studentId) {
        return res.status(400).json({ error: 'Invalid payment data' });
    }
    try {
        const paymentIntent = await stripe.paymentIntents.create({
            amount: amount * 100, // Convert to cents
            currency,
            metadata: { studentId },
        });
        res.status(200).json({ clientSecret: paymentIntent.client_secret });
    } catch (error) {
        console.error(error);
        res.status(500).json({ error: 'Error creating payment intent' });
    }
});

// 3. Webhook for Stripe payment success
app.post('/webhook', async (req, res) => {
    const sig = req.headers['stripe-signature'];
    const endpointSecret = process.env.STRIPE_WEBHOOK_SECRET; // Use environment variable for webhook secret

    try {
        const event = stripe.webhooks.constructEvent(req.body, sig, endpointSecret);

        if (event.type === 'payment_intent.succeeded') {
            const paymentIntent = event.data.object;
            const studentId = paymentIntent.metadata.studentId;
            await prisma.payment.create({
                data: {
                    amount: paymentIntent.amount / 100,
                    currency: paymentIntent.currency,
                    studentId,
                    paymentStatus: 'Succeeded',
                },
            });
            console.log(`Payment succeeded for student ID: ${studentId}`);
        }
        res.status(200).json({ received: true });
    } catch (error) {
        console.error(`Webhook error: ${error.message}`);
        res.status(400).send(`Webhook Error: ${error.message}`);
    }
});

// 4. Retrieve payment history for a student
app.get('/students/:id/payments', async (req, res) => {
    const { id } = req.params;
    try {
        const payments = await prisma.payment.findMany({
            where: { studentId: id },
        });
        res.status(200).json(payments);
    } catch (error) {
        console.error(error);
        res.status(500).json({ error: 'Error retrieving payment history' });
    }
});

// Start server
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Server running on port ${PORT}`);
});
