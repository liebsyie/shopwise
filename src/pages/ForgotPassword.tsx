import { useState } from 'react';
import { Link } from 'react-router-dom';
import { Navigation } from '../components/Navigation';
import { ShoppingCart } from 'lucide-react';
import Footer from '../components/Footer';

const ForgotPassword = () => {
  const [email, setEmail] = useState('');
  const [submitted, setSubmitted] = useState(false);
  const [error, setError] = useState<string | null>(null);

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    setError(null);
    if (!email) {
      setError('Please enter your email address.');
      return;
    }
    // Simulate sending reset email
    setSubmitted(true);
  };

  return (
    <div className="flex flex-col min-h-screen">
      <div className="fixed inset-0 -z-10 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-indigo-200/50 via-slate-100/30 to-blue-100/40"></div>
      <div className="fixed inset-0 -z-10 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-[0.15]"></div>
      <Navigation />
      <div className="flex-1">
        <div className="container mx-auto px-4 py-12">
          <div className="max-w-md mx-auto">
            <div className="text-center mb-8">
              <div className="flex justify-center">
                <ShoppingCart className="text-blue-600" size={40} />
              </div>
              <h1 className="mt-4 text-3xl font-bold text-gray-800" style={{ fontFamily: "'Montserrat', sans-serif" }}>
                Forgot Password
              </h1>
              <p className="mt-2 text-gray-600">
                Enter your email and we'll send you a reset link
              </p>
            </div>
            <div className="bg-white/90 backdrop-blur-md rounded-xl shadow-lg p-8 w-full max-w-md border border-white/50">
              {submitted ? (
                <div className="text-center">
                  <h2 className="text-2xl font-bold text-gray-800 mb-4">Check your email</h2>
                  <p className="text-gray-600 mb-6">If an account exists for <span className="font-medium">{email}</span>, you will receive a password reset link shortly.</p>
                  <Link to="/login" className="text-blue-600 hover:underline font-medium">Back to Sign In</Link>
                </div>
              ) : (
                <form onSubmit={handleSubmit}>
                  <div className="mb-4">
                    <label htmlFor="email" className="block text-gray-700 font-medium mb-1">
                      Email
                    </label>
                    <input
                      type="email"
                      id="email"
                      className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                      placeholder="you@example.com"
                      value={email}
                      onChange={e => setEmail(e.target.value)}
                    />
                  </div>
                  {error && <div className="bg-red-50 text-red-600 p-3 rounded-lg mb-4">{error}</div>}
                  <button
                    type="submit"
                    className="w-full bg-gradient-primary text-white py-2 px-4 rounded-lg hover:shadow-lg hover:translate-y-[-1px] active:translate-y-[0px] transition font-medium"
                  >
                    Send Reset Link
                  </button>
                </form>
              )}
            </div>
            <div className="mt-6 text-center text-gray-600">
              Remembered your password?{' '}
              <Link to="/login" className="text-blue-600 hover:underline font-medium">
                Sign in
              </Link>
            </div>
          </div>
        </div>
      </div>
      <Footer />
    </div>
  );
};

export default ForgotPassword;
