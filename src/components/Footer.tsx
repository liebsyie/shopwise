import { Link } from 'react-router-dom';
import { ShoppingCart } from 'lucide-react';

const Footer = () => (
  <footer className="bg-gray-900 text-white py-8 px-8 mt-auto w-full">
    <div className="container mx-auto">
      <div className="flex flex-col md:flex-row justify-between items-center">
        <div className="flex items-center gap-2 mb-4 md:mb-0">
          <div className="p-1.5 bg-gradient-to-br from-indigo-600 to-violet-600 rounded-lg">
            <ShoppingCart className="text-white" size={20} />
          </div>
          <span className="font-bold text-xl" style={{ fontFamily: "'Outfit', sans-serif" }}>ShopWise</span>
        </div>
        <nav className="flex gap-4 text-gray-400 text-sm mb-4 md:mb-0">
          <Link to="/privacy" className="hover:text-white transition">Privacy Policy</Link>
          <Link to="/terms" className="hover:text-white transition">Terms</Link>
          <Link to="/contact" className="hover:text-white transition">Contact</Link>
        </nav>
        <div className="text-gray-400 text-sm">
          © {new Date().getFullYear()} ShopWise. All rights reserved.
        </div>
      </div>
    </div>
  </footer>
);

export default Footer;
