import { useEffect, useState } from 'react';
import { useNavigate, useLocation } from 'react-router-dom';
import { X, MessageSquare } from 'lucide-react';

const Feedback = () => {
  const navigate = useNavigate();
  const location = useLocation();
  const [form, setForm] = useState({ feedback: '' });
  const [status, setStatus] = useState<'idle' | 'success'>('idle');
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

  const handleChange = (e: React.ChangeEvent<HTMLTextAreaElement>) => {
    setForm({ feedback: e.target.value });
    setError('');
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (!form.feedback.trim()) {
      setError('Please enter your feedback.');
      return;
    }
    setStatus('success');
    setTimeout(() => setStatus('idle'), 2500);
    setForm({ feedback: '' });
  };

  return (
    <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm animate-fade-in">
      <div className="bg-white/90 rounded-2xl shadow-2xl w-full max-w-xl mx-2 sm:mx-4 p-0 relative border border-white/40 ring-1 ring-indigo-100 animate-fade-in-up flex flex-col max-h-[90vh]">
        <div className="flex items-center justify-between px-4 py-3 border-b border-gray-100 sticky top-0 bg-white/95 rounded-t-2xl z-10">
          <h1 className="text-lg sm:text-2xl font-bold text-indigo-700 text-center w-full flex items-center justify-center gap-2"><MessageSquare size={22}/>Feedback</h1>
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
          <form className="space-y-4" onSubmit={handleSubmit}>
            <label className="block text-gray-700 font-medium mb-1" htmlFor="feedback">Your Feedback</label>
            <textarea
              id="feedback"
              name="feedback"
              className="w-full py-2 px-3 rounded-lg border border-gray-200 outline-none bg-white resize-none min-h-[80px]"
              placeholder="Let us know what you love, what could be better, or any ideas you have!"
              value={form.feedback}
              onChange={handleChange}
              required
            />
            {error && <div className="text-red-600 text-sm">{error}</div>}
            {status === 'success' && <div className="text-green-600 text-sm">Thank you for your feedback!</div>}
            <button
              type="submit"
              className="w-full bg-gradient-to-r from-indigo-500 via-violet-500 to-blue-500 text-white py-2 rounded-xl shadow-lg hover:scale-105 hover:shadow-xl transition-all duration-200 font-semibold border-2 border-transparent hover:border-indigo-300 focus:outline-none focus:ring-2 focus:ring-indigo-400"
              disabled={status === 'success'}
            >
              Submit
            </button>
          </form>
          <div className="mt-8 text-xs text-gray-400 text-center">
            Your feedback is anonymous and helps us improve ShopWise.
          </div>
        </div>
      </div>
    </div>
  );
};

export default Feedback;
