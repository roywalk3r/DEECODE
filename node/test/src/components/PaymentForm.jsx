import React, { useState, useEffect } from 'react';
import { useForm } from 'react-hook-form';
import { loadStripe } from '@stripe/stripe-js';
import { Elements, CardElement, useStripe, useElements } from '@stripe/react-stripe-js';
import { Link } from 'react-router-dom';

const stripePromise = loadStripe("pk_test_TYooMQauvdEDq54NiTphI7jx");

function PaymentFormContent() {
  const { register, handleSubmit, formState: { errors } } = useForm();
  const [message, setMessage] = useState('');
  const stripe = useStripe();
  const elements = useElements();

  const onSubmit = async (data) => {
    if (!stripe || !elements) {
      setMessage('Stripe has not been properly initialized. Please check your configuration.');
      return;
    }

    try {
      const response = await fetch('http://localhost:3000/api/payments/create', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data),
      });
      console.log("Data", data);
      if (!response.ok) {
        throw new Error('Failed to create payment intent');
      }

      const { clientSecret } = await response.json();

      const result = await stripe.confirmCardPayment(clientSecret, {
        payment_method: {
          card: elements.getElement(CardElement),
        },
      });

      if (result.error) {
        setMessage(result.error.message || 'Payment failed');
      } else {
        setMessage('Payment successful!');
      }
    } catch (error) {
      setMessage('Error processing payment');
    }
  };

  return (
    <form onSubmit={handleSubmit(onSubmit)}>
      <div className="mb-4">
        <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="amount">
          Amount
        </label>
        <input
          {...register('amount', { required: 'Amount is required', min: { value: 0.01, message: 'Amount must be positive' } })}
          className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          id="amount"
          type="number"
          step="0.01"
          placeholder="Amount"
        />
        {errors.amount && <p className="text-red-500 text-xs italic">{errors.amount.message}</p>}
      </div>
      <div className="mb-4">
        <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="currency">
          Currency
        </label>
        <select
          {...register('currency', { required: 'Currency is required' })}
          className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          id="currency"
        >
          <option value="">Select currency</option>
          <option value="usd">USD</option>
          <option value="eur">EUR</option>
          <option value="gbp">GBP</option>
        </select>
        {errors.currency && <p className="text-red-500 text-xs italic">{errors.currency.message}</p>}
      </div>
      <div className="mb-4">
        <label className="block text-gray-700 text-sm font-bold mb-2" htmlFor="studentId">
          Student ID
        </label>
        <input
          {...register('studentId', { required: 'Student ID is required' })}
          className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          id="studentId"
          type="text"
          placeholder="Student ID"
        />
        {errors.studentId && <p className="text-red-500 text-xs italic">{errors.studentId.message}</p>}
      </div>
      <div className="mb-6">
        <label className="block text-gray-700 text-sm font-bold mb-2">
          Card Details
        </label>
        <CardElement className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
      </div>
      <div className="flex items-center justify-between">
        <button
          className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
          type="submit"
        >
          Pay
        </button>
        <Link to="/history" className="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
          View Payment History
        </Link>
      </div>
      {message && <p className="mt-4 text-green-500">{message}</p>}
    </form>
  );
}

export default function PaymentForm() {
  const [stripeError, setStripeError] = useState(null);

  // useEffect(() => {
  //   if (!import.meta.env.REACT_APP_STRIPE_PUBLISHABLE_KEY) {
  //     setStripeError('Stripe publishable key is not set. Please check your environment variables.');
  //   }
  // }, []);

  if (stripeError) {
    return (
      <div className="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 className="text-2xl font-bold mb-4">Payment Form</h2>
        <p className="text-red-500">{stripeError}</p>
      </div>
    );
  }

  return (
    <div className="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
      <h2 className="text-2xl font-bold mb-4">Make a Payment</h2>
      {stripePromise ? (
        <Elements stripe={stripePromise}>
          <PaymentFormContent />
        </Elements>
      ) : (
        <p>Loading payment form...</p>
      )}
    </div>
  );
}

