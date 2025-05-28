import { useEffect } from 'react';
import { useNavigate, useLocation } from 'react-router-dom';
import { X, Info } from 'lucide-react';

const About = () => {
  const navigate = useNavigate();
  const location = useLocation();

  const handleClose = () => {
    if (location.state && location.state.background) {
      navigate(-1);
    } else {
      navigate('/dashboard');
    }
  };

  useEffect(() => {
    const handleEsc = (e: KeyboardEvent) => {
      if (e.key === 'Escape') handleClose();
    };
    window.addEventListener('keydown', handleEsc);
    return () => window.removeEventListener('keydown', handleEsc);
  }, []);

  return (
    <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm animate-fade-in">
      <div className="bg-white/90 rounded-2xl shadow-2xl w-full max-w-2xl mx-2 sm:mx-4 p-0 relative border border-white/40 ring-1 ring-indigo-100 animate-fade-in-up flex flex-col max-h-[90vh]">
        <div className="flex items-center justify-between px-4 py-3 border-b border-gray-100 sticky top-0 bg-white/95 rounded-t-2xl z-10">
          <h1 className="text-lg sm:text-2xl font-bold text-indigo-700 text-center w-full flex items-center justify-center gap-2"><Info size={22}/>About ShopWise</h1>
          <button
            onClick={handleClose}
            className="absolute right-4 top-3 text-gray-500 hover:text-indigo-600 text-2xl font-bold rounded-full p-2 transition bg-white/80"
            aria-label="Close"
            style={{ lineHeight: 1 }}
          >
            <X size={28} />
          </button>
        </div>
        <div className="overflow-y-auto px-4 py-4 sm:px-8 sm:py-8 flex-1" style={{ WebkitOverflowScrolling: 'touch' }}>
          <div className="space-y-6 text-gray-700 text-base">
            <p><b>ShopWise</b> is your smart companion for grocery shopping and budget management. Our mission is to help you save money, stay organized, and make shopping stress-free.</p>
            <ul className="list-disc ml-6">
              <li>Create and manage categorized shopping lists</li>
              <li>Track your spending and set budgets</li>
              <li>Access your lists from any device (data stays in your browser)</li>
              <li>Enjoy a beautiful, modern, and privacy-friendly experience</li>
            </ul>
            <p>ShopWise is built with privacy in mind—your data stays on your device. We welcome your feedback and suggestions to make ShopWise even better!</p>
          </div>
        </div>
      </div>
    </div>
  );
};

export default About;
