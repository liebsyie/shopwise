import { useNavigate, useLocation } from 'react-router-dom';
import { ShoppingCart } from 'lucide-react';

const Footer = () => {
  const navigate = useNavigate();
  const location = useLocation();

  const openModal = (path: string) => {
    navigate(path, { state: { background: location } });
  };

  return (
    <footer className="bg-gray-900 text-white py-4 mt-auto w-full border-t border-gray-800">
      <div className="container mx-auto px-4">
        <div className="flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-4">
          {/* Logo + Copyright */}
          <div className="flex items-center gap-2 order-1 sm:order-none">
            <div className="p-1 bg-gradient-to-br from-indigo-600 to-violet-600 rounded">
              <ShoppingCart className="text-white" size={16} />
            </div>
            <span className="text-sm text-gray-400">© {new Date().getFullYear()} ShopWise</span>
          </div>

          {/* Navigation Links */}
          <nav className="flex flex-wrap justify-center gap-x-4 gap-y-1 text-xs order-2 sm:order-none">
            <button onClick={() => openModal('/about')} className="text-gray-400 hover:text-white transition">About</button>
            <button onClick={() => openModal('/faq')} className="text-gray-400 hover:text-white transition">Help</button>
            <button onClick={() => openModal('/feedback')} className="text-gray-400 hover:text-white transition">Feedback</button>
            <button onClick={() => openModal('/privacy')} className="text-gray-400 hover:text-white transition">Privacy</button>
            <button onClick={() => openModal('/terms')} className="text-gray-400 hover:text-white transition">Terms</button>
            <button onClick={() => openModal('/contact')} className="text-gray-400 hover:text-white transition">Contact</button>
          </nav>
        </div>
      </div>
    </footer>
  );
};

export default Footer;
