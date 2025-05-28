import { useEffect } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { LoginForm } from '../components/AuthForms';
import { Navigation } from '../components/Navigation';
import { ShoppingCart } from 'lucide-react';
import { useAuth } from '../context/AuthContext';
import Footer from '../components/Footer';

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
                Sign in to ShopWise
              </h1>
              <p className="mt-2 text-gray-600">
                Track your grocery budget and never overspend again
              </p>
            </div>
            <LoginForm />
            <div className="mt-6 text-center text-gray-600">
              Don't have an account?{' '}
              <Link to="/register" className="text-indigo-600 hover:underline font-semibold transition-colors">
                Sign up
              </Link>
            </div>
            <div className="mt-2 text-center">
              <Link to="/forgot-password" className="text-sm text-indigo-500 hover:underline font-medium transition-colors">
                Forgot Password?
              </Link>
            </div>
          </div>
        </div>
      </div>
      <Footer />
    </div>
  );
};

export default Login;
