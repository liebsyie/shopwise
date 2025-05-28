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
    <div className="flex flex-col min-h-screen font-[Outfit,sans-serif] bg-gradient-to-br from-indigo-100 via-blue-50 to-violet-100">
      <div className="fixed inset-0 -z-10 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-indigo-200/60 via-slate-100/40 to-blue-100/50"></div>
      <div className="fixed inset-0 -z-10 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-[0.13]"></div>
      <Navigation />
      <div className="flex-1 flex items-center justify-center">
        <div className="container mx-auto px-4 py-12">
          <div className="max-w-md mx-auto bg-white/60 backdrop-blur-2xl rounded-2xl shadow-xl border border-white/40 ring-1 ring-indigo-100 p-8 animate-fade-in">
            <div className="text-center mb-8">
              <div className="flex justify-center">
                <ShoppingCart className="text-indigo-500 drop-shadow-lg" size={44} />
              </div>
              <h1 className="mt-4 text-3xl font-extrabold text-gray-800 tracking-tight drop-shadow-sm" style={{ fontFamily: "'Outfit', 'Montserrat', sans-serif" }}>
                Forgot Password
              </h1>
              <p className="mt-2 text-gray-600">
                Enter your email and we'll send you a reset link
              </p>
            </div>
            {submitted ? (
              <div className="text-center animate-fade-in">
                <h2 className="text-2xl font-bold text-gray-800 mb-4">Check your email</h2>
                <p className="text-gray-600 mb-6">If an account exists for <span className="font-medium">{email}</span>, you will receive a password reset link shortly.</p>
                <Link to="/login" className="text-indigo-600 hover:underline font-semibold transition-colors">Back to Sign In</Link>
              </div>
            ) : (
              <form onSubmit={handleSubmit} className="animate-fade-in">
                <div className="mb-4 text-left">
                  <label htmlFor="email" className="block text-gray-700 font-semibold mb-1">
                    Email
                  </label>
                  <input
                    type="email"
                    id="email"
                    className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none transition bg-white/80 shadow-sm hover:shadow-md"
                    placeholder="you@example.com"
                    value={email}
                    onChange={e => setEmail(e.target.value)}
                  />
                </div>
                {error && <div className="bg-red-50 text-red-600 p-3 rounded-lg mb-4 animate-shake border border-red-200 shadow">{error}</div>}
                <button
                  type="submit"
                  className="w-full bg-gradient-to-r from-indigo-500 via-violet-500 to-blue-500 text-white py-2 px-4 rounded-xl shadow-lg hover:scale-105 hover:shadow-xl transition-all duration-200 font-semibold border-2 border-transparent hover:border-indigo-300 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                >
                  Send Reset Link
                </button>
              </form>
            )}
            <div className="mt-6 text-center text-gray-600">
              Remembered your password?{' '}
              <Link to="/login" className="text-indigo-600 hover:underline font-semibold transition-colors">
                Sign in
              </Link>
            </div>
            <div className="mt-8 text-center text-gray-500 text-sm">
              <Link to="/privacy" className="text-indigo-600 hover:underline font-semibold transition-colors">
                Privacy Policy
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
