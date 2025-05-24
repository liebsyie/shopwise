import { useEffect } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { RegisterForm } from '../components/AuthForms';
import { Navigation } from '../components/Navigation';
import { ShoppingCart } from 'lucide-react';
import { useAuth } from '../context/AuthContext';
import Footer from '../components/Footer';

const Register = () => {
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
                Create your account
              </h1>
              <p className="mt-2 text-gray-600">
                Join ShopWise to manage your shopping budget
              </p>
            </div>
            
            <RegisterForm />
            
            <div className="mt-6 text-center text-gray-600">
              Already have an account?{' '}
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

export default Register;
