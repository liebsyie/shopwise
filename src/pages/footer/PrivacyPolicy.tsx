import Footer from '../../components/Footer';
import { Navigation } from '../../components/Navigation';
import { useEffect } from 'react';
import { useNavigate, useLocation } from 'react-router-dom';
import { X } from 'lucide-react';

export const PrivacyPolicyContent = () => (
  <div className="space-y-6 text-gray-700 text-base">
    <section>
      <h2 className="font-semibold text-lg mb-2">1. Information We Collect</h2>
      <ul className="list-disc ml-6">
        <li>Personal information (name, email, profile photo) provided during registration.</li>
        <li>Shopping lists, items, and budget data you create in the app.</li>
        <li>Usage data (e.g., last login, account creation date) for account management.</li>
      </ul>
    </section>
    <section>
      <h2 className="font-semibold text-lg mb-2">2. How We Use Your Information</h2>
      <ul className="list-disc ml-6">
        <li>To provide and improve the ShopWise service.</li>
        <li>To personalize your experience and save your data securely in your browser.</li>
        <li>To communicate important updates or changes to your account.</li>
      </ul>
    </section>
    <section>
      <h2 className="font-semibold text-lg mb-2">3. Data Storage & Security</h2>
      <ul className="list-disc ml-6">
        <li>Your data is stored locally in your browser and is not shared with third parties.</li>
        <li>We use secure methods to protect your information, but no system is 100% secure.</li>
      </ul>
    </section>
    <section>
      <h2 className="font-semibold text-lg mb-2">4. Your Rights & Choices</h2>
      <ul className="list-disc ml-6">
        <li>You can update or delete your account and data at any time from your profile page.</li>
        <li>You may export your data using the provided tools.</li>
      </ul>
    </section>
    <section>
      <h2 className="font-semibold text-lg mb-2">5. Changes to This Policy</h2>
      <ul className="list-disc ml-6">
        <li>We may update this Privacy Policy from time to time. Changes will be posted on this page.</li>
      </ul>
    </section>
    <section>
      <h2 className="font-semibold text-lg mb-2">6. Contact Us</h2>
      <ul className="list-disc ml-6">
        <li>If you have questions or concerns about your privacy, please contact us at <a href="mailto:support@shopwise.com" className="text-indigo-600 underline">support@shopwise.com</a>.</li>
      </ul>
    </section>
  </div>
);

const PrivacyPolicy = () => {
  const navigate = useNavigate();
  const location = useLocation();

  // If opened as a modal, go back to previous page on close
  const handleClose = () => {
    if (location.state && location.state.background) {
      navigate(-1);
    } else {
      navigate('/dashboard'); // fallback
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
          <h1 className="text-lg sm:text-2xl font-bold text-indigo-700 text-center w-full">Privacy Policy</h1>
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
          <PrivacyPolicyContent />
        </div>
      </div>
    </div>
  );
};

export default PrivacyPolicy;
