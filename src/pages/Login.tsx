import { useEffect } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { LoginForm } from '../components/AuthForms';
import { ShoppingCart } from 'lucide-react';
import { useAuth } from '../context/AuthContext';

const Login = () => {
  const { isAuthenticated } = useAuth();
  const navigate = useNavigate();

  useEffect(() => {
    const link = document.createElement('link');
    link.href = 'https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Montserrat:wght@700;800&display=swap';
    link.rel = 'stylesheet';
    document.head.appendChild(link);
    if (isAuthenticated) {
      navigate('/dashboard');
    }
    return () => {
      document.head.removeChild(link);
    };
  }, [isAuthenticated, navigate]);

  return (
    <div className="min-h-screen bg-gradient-to-b from-blue-50 to-blue-100" style={{ fontFamily: "'Inter', sans-serif" }}>
      <div className="fixed inset-0 -z-10 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-indigo-200/50 via-slate-100/30 to-blue-100/40"></div>
      <div className="fixed inset-0 -z-10 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-[0.15]"></div>
      
      {/* Consistent Header */}
      <header className="py-6 px-8 flex justify-between items-center">
        <div className="flex items-center gap-2">
          <Link to="/" className="flex items-center gap-2">
            <div className="p-2 bg-gradient-to-br from-indigo-600 to-violet-600 rounded-lg shadow-lg">
              <ShoppingCart className="text-white" size={24} />
            </div>
            <span className="font-bold text-2xl gradient-text" style={{ fontFamily: "'Outfit', sans-serif" }}>ShopWise</span>
          </Link>
        </div>
        <div className="flex gap-4">
          <Link to="/login" className="py-2 px-4 rounded-lg text-indigo-600 font-medium hover:bg-white hover:shadow-sm transition duration-300">
            Login
          </Link>
          <Link to="/register" className="py-2 px-5 bg-gradient-primary text-white rounded-lg font-medium hover:shadow-md hover:translate-y-[-2px] active:translate-y-[0px] transition duration-300 flex items-center gap-1">
            <span>Sign Up</span>
          </Link>
        </div>
      </header>

      <div className="container mx-auto px-4 py-12">
        <div className="max-w-md mx-auto">
          <div className="text-center mb-8">
            <div className="flex justify-center">
              <ShoppingCart className="text-blue-600" size={40} />
            </div>
            <h1 className="mt-4 text-3xl font-bold text-gray-800" style={{ fontFamily: "'Montserrat', sans-serif" }}>
              Sign in to ShopWise
            </h1>
            <p className="mt-2 text-gray-600">
              Track your grocery budget and never overspend again
            </p>
          </div>
          <LoginForm />
          <div className="mt-6 text-center text-gray-600">
            Don't have an account?{' '}
            <Link to="/register" className="text-blue-600 hover:underline font-medium">
              Sign up
            </Link>
          </div>
          <div className="mt-4 text-center">
            <Link to="/forgot-password" className="text-blue-600 hover:underline font-medium">
              Forgot Password?
            </Link>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Login;
