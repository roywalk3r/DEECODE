'use client'

import { useEffect, useState } from 'react'
import { useSession } from 'next-auth/react'
import { Elements } from '@stripe/react-stripe-js'
import { loadStripe } from '@stripe/stripe-js'
import PaymentForm from '@/app/components/PaymentForm'
import { Toaster } from 'sonner'

const stripePromise = loadStripe(process.env.NEXT_PUBLIC_STRIPE_PUBLISHABLE_KEY!)

interface Payment {
  id: string
  amount: number
  status: string
  description: string
  createdAt: string
}

export default function Dashboard() {
  const { data: session, status } = useSession()
  const [payments, setPayments] = useState<Payment[]>([])
  const [totalFees, setTotalFees] = useState(0)
  const [pendingBalance, setPendingBalance] = useState(0)
  const [loading, setLoading] = useState(true)

  useEffect(() => {
    if (session) {
      fetchPayments()
      fetchFeeInfo()
    }
  }, [session])

  const fetchPayments = async () => {
    try {
      const response = await fetch('/api/payments')
      const data = await response.json()
      setPayments(data.payments)
    } catch (error) {
      console.error('Error fetching payments:', error)
    }
  }

  const fetchFeeInfo = async () => {
    try {
      const response = await fetch('/api/fees/summary')
      const data = await response.json()
      setTotalFees(data.totalFees)
      setPendingBalance(data.pendingBalance)
    } catch (error) {
      console.error('Error fetching fee info:', error)
    } finally {
      setLoading(false)
    }
  }

  const handlePaymentSuccess = () => {
    fetchPayments()
    fetchFeeInfo()
  }

  if (status === 'loading' || loading) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-primary"></div>
      </div>
    )
  }

  if (status === 'unauthenticated') {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <div className="text-center">
          <h1 className="text-2xl font-bold mb-4">Access Denied</h1>
          <p className="text-gray-600">Please sign in to view this page.</p>
        </div>
      </div>
    )
  }

  return (
    <div className="min-h-screen bg-gray-50">
      <Toaster position="top-right" />
      <header className="bg-white shadow">
        <div className="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
          <div className="flex justify-between items-center">
            <h1 className="text-3xl font-bold text-gray-900">Dashboard</h1>
            <div className="text-sm text-gray-600">
              Welcome, {session?.user?.name}
            </div>
          </div>
        </div>
      </header>

      <main className="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div className="px-4 py-6 sm:px-0">
          <div className="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-3">
            <div className="flex items-center p-4 bg-white rounded-lg shadow-xs">
              <div>
                <p className="mb-2 text-sm font-medium text-gray-600">
                  Total Fees
                </p>
                <p className="text-2xl font-semibold text-gray-700">
                  ${totalFees.toFixed(2)}
                </p>
              </div>
            </div>

            <div className="flex items-center p-4 bg-white rounded-lg shadow-xs">
              <div>
                <p className="mb-2 text-sm font-medium text-gray-600">
                  Pending Balance
                </p>
                <p className="text-2xl font-semibold text-gray-700">
                  ${pendingBalance.toFixed(2)}
                </p>
              </div>
            </div>
          </div>

          <div className="bg-white rounded-lg shadow-xs p-6">
            <h2 className="text-xl font-semibold mb-4">Payment History</h2>
            <div className="overflow-x-auto">
              <table className="min-w-full divide-y divide-gray-200">
                <thead className="bg-gray-50">
                  <tr>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Date
                    </th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Description
                    </th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Amount
                    </th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Status
                    </th>
                  </tr>
                </thead>
                <tbody className="bg-white divide-y divide-gray-200">
                  {payments.map((payment) => (
                    <tr key={payment.id}>
                      <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {new Date(payment.createdAt).toLocaleDateString()}
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {payment.description}
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        ${payment.amount.toFixed(2)}
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap">
                        <span className={`px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${
                          payment.status === 'succeeded'
                            ? 'bg-green-100 text-green-800'
                            : payment.status === 'pending'
                            ? 'bg-yellow-100 text-yellow-800'
                            : 'bg-red-100 text-red-800'
                        }`}>
                          {payment.status}
                        </span>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </div>

          <div className="mt-8 bg-white rounded-lg shadow-xs p-6">
            <h2 className="text-xl font-semibold mb-4">Make a Payment</h2>
            <Elements stripe={stripePromise}>
              <PaymentForm onSuccess={handlePaymentSuccess} />
            </Elements>
          </div>
        </div>
      </main>
    </div>
  )
}
