import React from 'react';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import StudentRegistration from './components/StudentRegistration';
import PaymentForm from './components/PaymentForm';
import PaymentHistory from './components/PaymentHistory';
 function App() {
    return (
        <Router>
            <div className="container mx-auto px-4 py-8">
                <h1 className="text-4xl font-bold mb-8">Tuition Payment System</h1>
                <Routes>
                    <Route path="/" element={<StudentRegistration />} />
                    <Route path="/payment" element={<PaymentForm />} />
                    <Route path="/history" element={<PaymentHistory />} />
                </Routes>
            </div>
        </Router>
    );
}

export default App;

