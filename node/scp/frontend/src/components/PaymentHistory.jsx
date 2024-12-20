import React, { useState } from 'react';
import { Link } from 'react-router-dom';

export default function PaymentHistory() {
  const [studentId, setStudentId] = useState('');
  const [payments, setPayments] = useState([]);
  const [message, setMessage] = useState('');

  const fetchPayments = async () => {
    try {
      const response = await fetch(`http://localhost:5000/api/students/${studentId}/payments`);
      if (response.ok) {
        const data = await response.json();
        setPayments(data);
        setMessage('');
      } else {
        setMessage('Error fetching payment history');
      }
    } catch (error) {
      setMessage('Error fetching payment history');
    }
  };

  return (
    <div className="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 mt-8">
      <h2 className="text-2xl font-bold mb-4">Payment History</h2>
      <div className="flex mb-4">
        <input
          type="text"
          value={studentId}
          onChange={(e) => setStudentId(e.target.value)}
          placeholder="Enter Student ID"
          className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2"
        />
        <button
          onClick={fetchPayments}
          className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
        >
          Fetch Payments
        </button>
      </div>
      {message && <p className="text-red-500 mb-4">{message}</p>}
      {payments.length > 0 ? (
        <table className="w-full">
          <thead>
            <tr>
              <th className="px-4 py-2">Date</th>
              <th className="px-4 py-2">Amount</th>
              <th className="px-4 py-2">Currency</th>
              <th className="px-4 py-2">Status</th>
            </tr>
          </thead>
          <tbody>
            {payments.map((payment) => (
              <tr key={payment.id}>
                <td className="border px-4 py-2">{new Date(payment.createdAt).toLocaleDateString()}</td>
                <td className="border px-4 py-2">{payment.amount}</td>
                <td className="border px-4 py-2">{payment.currency.toUpperCase()}</td>
                <td className="border px-4 py-2">{payment.paymentStatus}</td>
              </tr>
            ))}
          </tbody>
        </table>
      ) : (
        <p>No payment history available.</p>
      )}
      <div className="mt-4">
        <Link to="/" className="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
          Back to Registration
        </Link>
      </div>
    </div>
  );
}

