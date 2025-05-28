import { useEffect, useState } from 'react';
import { useNavigate, useLocation } from 'react-router-dom';
import { X, Mail, User as UserIcon, MessageCircle } from 'lucide-react';

const Contact = () => {
  const navigate = useNavigate();
  const location = useLocation();
  const [form, setForm] = useState({ name: '', email: '', message: '' });
  const [status, setStatus] = useState<'idle' | 'success' | 'error'>('idle');
  const [error, setError] = useState('');

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

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => {
    setForm({ ...form, [e.target.name]: e.target.value });
    setError('');
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (!form.email || !form.message) {
      setError('Please provide your email and message.');
      return;
    }
    setStatus('success');
    setTimeout(() => setStatus('idle'), 2500);
    setForm({ name: '', email: '', message: '' });
  };

  return (
    <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm animate-fade-in">
      <div className="bg-white/90 rounded-2xl shadow-2xl w-full max-w-2xl mx-2 sm:mx-4 p-0 relative border border-white/40 ring-1 ring-indigo-100 animate-fade-in-up flex flex-col max-h-[90vh]">
        <div className="flex items-center justify-between px-4 py-3 border-b border-gray-100 sticky top-0 bg-white/95 rounded-t-2xl z-10">
          <h1 className="text-lg sm:text-2xl font-bold text-indigo-700 text-center w-full">Contact Us</h1>
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
          <div className="mb-6 space-y-2">
            <div className="flex items-center gap-2 text-gray-700"><Mail size={18} /> <span>support@shopwise.com</span></div>
            <div className="text-gray-500 text-sm">We typically respond within 1-2 business days.</div>
          </div>
          <form className="space-y-4" onSubmit={handleSubmit}>
            <div>
              <label className="block text-gray-700 font-medium mb-1" htmlFor="name">Name</label>
              <div className="flex items-center bg-white rounded-lg border border-gray-200 px-3">
                <UserIcon size={16} className="text-gray-400 mr-2" />
                <input
                  type="text"
                  id="name"
                  name="name"
                  className="w-full py-2 outline-none bg-transparent"
                  placeholder="Your name (optional)"
                  value={form.name}
                  onChange={handleChange}
                  autoComplete="name"
                />
              </div>
            </div>
            <div>
              <label className="block text-gray-700 font-medium mb-1" htmlFor="email">Email<span className="text-red-500">*</span></label>
              <div className="flex items-center bg-white rounded-lg border border-gray-200 px-3">
                <Mail size={16} className="text-gray-400 mr-2" />
                <input
                  type="email"
                  id="email"
                  name="email"
                  className="w-full py-2 outline-none bg-transparent"
                  placeholder="you@example.com"
                  value={form.email}
                  onChange={handleChange}
                  autoComplete="email"
                  required
                />
              </div>
            </div>
            <div>
              <label className="block text-gray-700 font-medium mb-1" htmlFor="message">Message<span className="text-red-500">*</span></label>
              <div className="flex items-start bg-white rounded-lg border border-gray-200 px-3">
                <MessageCircle size={16} className="text-gray-400 mr-2 mt-2" />
                <textarea
                  id="message"
                  name="message"
                  className="w-full py-2 outline-none bg-transparent resize-none min-h-[80px]"
                  placeholder="How can we help you?"
                  value={form.message}
                  onChange={handleChange}
                  required
                />
              </div>
            </div>
            {error && <div className="text-red-600 text-sm">{error}</div>}
            {status === 'success' && <div className="text-green-600 text-sm">Thank you! Your message has been sent.</div>}
            <button
              type="submit"
              className="w-full bg-gradient-to-r from-indigo-500 via-violet-500 to-blue-500 text-white py-2 rounded-xl shadow-lg hover:scale-105 hover:shadow-xl transition-all duration-200 font-semibold border-2 border-transparent hover:border-indigo-300 focus:outline-none focus:ring-2 focus:ring-indigo-400"
              disabled={status === 'success'}
            >
              Send Message
            </button>
          </form>
          <div className="mt-8 text-xs text-gray-400 text-center">
            Your information is used only to respond to your inquiry and is not shared.
          </div>
        </div>
      </div>
    </div>
  );
};

export default Contact;
