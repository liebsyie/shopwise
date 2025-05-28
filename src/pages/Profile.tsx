import { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom'; // Removed unused Link import
import { useAuth } from '../context/AuthContext';
import { Navigation } from '../components/Navigation';
import { Camera, User, Trash2, ArrowLeft } from 'lucide-react';
import Footer from '../components/Footer';

const Profile = () => {
  const { currentUser, updateProfile, deleteAccount, logout } = useAuth();
  const navigate = useNavigate();
  const [nickname, setNickname] = useState(currentUser?.name || '');
  const [profileImage, setProfileImage] = useState(currentUser?.photoURL || '');
  const [isEditing, setIsEditing] = useState(false);
  const [message, setMessage] = useState<string | null>(null);
  const [messageType, setMessageType] = useState<'success' | 'info' | null>(null);
  const [showDeleteConfirm, setShowDeleteConfirm] = useState(false);
  const [showDeleteMessage, setShowDeleteMessage] = useState(false);

  useEffect(() => {
    const link = document.createElement('link');
    link.href = 'https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Montserrat:wght@700;800&display=swap';
    link.rel = 'stylesheet';
    document.head.appendChild(link);
    
    return () => {
      document.head.removeChild(link);
    };
  }, []);

  const handleImageUpload = (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0];
    if (file) {
      // Check file type for common image formats
      const allowedTypes = [
        'image/jpeg', 'image/png', 'image/jpg', 'image/webp', 'image/gif', 'image/bmp', 'image/svg+xml', 'image/tiff', 'image/x-icon', 'image/vnd.microsoft.icon'
      ];
      if (!allowedTypes.includes(file.type)) {
        setMessage('Unsupported file type. Please upload a valid image.');
        setMessageType('info');
        setTimeout(() => setMessage(null), 2500);
        return;
      }
      // Warn if file is very large (e.g., > 50MB), but allow upload
      if (file.size > 50 * 1024 * 1024) {
        setMessage('Warning: Large image files may take longer to load.');
        setMessageType('info');
        setTimeout(() => setMessage(null), 2500);
      }
      const reader = new FileReader();
      reader.onload = (event) => {
        setProfileImage(event.target?.result as string);
      };
      reader.readAsDataURL(file);
    }
  };

  const handleSave = async (e?: React.FormEvent) => {
    if (e) e.preventDefault();
    const hasChanges = nickname !== (currentUser?.name || '') || profileImage !== (currentUser?.photoURL || '');
    if (!hasChanges) {
      setMessage('Profile no changes.');
      setMessageType('info');
      setIsEditing(false);
      setTimeout(() => setMessage(null), 2500);
      return;
    }
    try {
      await updateProfile({
        name: nickname,
        photoURL: profileImage
      });
      setMessage('Profile save changes.');
      setMessageType('success');
      setIsEditing(false);
      setTimeout(() => setMessage(null), 2500);
    } catch (error) {
      setMessage('Failed to save changes.');
      setMessageType('info');
      setTimeout(() => setMessage(null), 2500);
      console.error('Error updating profile:', error);
    }
  };

  const handleDeleteAccount = () => {
    setShowDeleteConfirm(true);
  };

  const handleDeleteConfirm = async () => {
    setShowDeleteConfirm(false);
    setShowDeleteMessage(true);
    setMessage('Account deleted successfully.');
    setMessageType('success');
    setTimeout(async () => {
      setShowDeleteMessage(false);
      await deleteAccount();
      logout();
      navigate('/');
    }, 1800);
  };

  const handleDeleteCancel = () => {
    setShowDeleteConfirm(false);
    setShowDeleteMessage(true);
    setMessage('Delete account canceled.');
    setMessageType('info');
    setTimeout(() => setShowDeleteMessage(false), 2000);
  };

  return (
    <div className="flex flex-col min-h-screen font-[Outfit,sans-serif] bg-gradient-to-br from-indigo-100 via-blue-50 to-violet-100">
      <div className="fixed inset-0 -z-10 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-indigo-200/60 via-slate-100/40 to-blue-100/50"></div>
      <div className="fixed inset-0 -z-10 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-[0.13]"></div>
      <Navigation />
      <div className="flex-1">
        <div className="container mx-auto px-4 py-8">
          <div className="flex items-center mb-6">
            <button 
              onClick={() => navigate(-1)} 
              className="inline-flex items-center text-indigo-600 hover:text-indigo-800 transition font-semibold p-0 mr-2 bg-transparent border-none shadow-none"
              style={{ boxShadow: 'none', background: 'none' }}
            >
              <ArrowLeft size={18} />
            </button>
            <h1 className="text-2xl font-bold text-indigo-600 hover:text-indigo-800 transition font-semibold" style={{ fontFamily: "'Outfit', 'Montserrat', sans-serif" }}>
              My Profile
            </h1>
          </div>
          <div className="bg-white/60 backdrop-blur-2xl rounded-2xl shadow-xl p-8 border border-white/40 ring-1 ring-indigo-100 max-w-2xl mx-auto relative animate-fade-in">
            {/* Success/Cancel Message */}
            {showDeleteMessage && message && (
              <div className={`fixed top-8 left-1/2 z-50 -translate-x-1/2 px-6 py-3 rounded-xl shadow-lg text-base font-semibold transition-all duration-300 animate-fade-in ${messageType === 'success' ? 'bg-green-500 text-white' : 'bg-blue-600 text-white'}`}>
                {message}
              </div>
            )}
            <div className="flex flex-col items-center mb-6">
              <div className="relative mb-4">
                <div className="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden">
                  {profileImage ? (
                    <img 
                      src={profileImage} 
                      alt="Profile" 
                      className="w-full h-full object-cover"
                    />
                  ) : (
                    <User size={40} className="text-gray-400" />
                  )}
                </div>
                {isEditing && (
                  <label className="absolute bottom-0 right-0 bg-indigo-600 text-white p-2 rounded-full cursor-pointer hover:bg-indigo-700 transition">
                    <Camera size={16} />
                    <input 
                      type="file"
                      accept="image/*"
                      onChange={handleImageUpload}
                      className="hidden"
                    />
                  </label>
                )}
              </div>
              <h2 className="text-xl font-semibold text-gray-800 mb-2">{nickname || 'No name set'}</h2>
              <button 
                onClick={() => setIsEditing(!isEditing)} 
                className="text-indigo-600 hover:underline mb-4 font-semibold transition-colors"
              >
                {isEditing ? 'Cancel' : 'Edit Profile'}
              </button>
              {message && (
                <div className={`mb-4 p-3 rounded-lg text-sm ${messageType === 'success' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800'}`}>{message}</div>
              )}
              {isEditing && (
                <form onSubmit={handleSave} className="w-full">
                  <div className="mb-4">
                    <label className="block text-gray-700 text-sm font-medium mb-2" htmlFor="nickname">
                      Nickname
                    </label>
                    <input 
                      type="text"
                      id="nickname"
                      value={nickname}
                      onChange={(e) => setNickname(e.target.value)}
                      className="w-full p-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-transparent bg-white/80 shadow-sm hover:shadow-md"
                      placeholder="Enter your nickname"
                      required
                    />
                  </div>
                  <button 
                    type="submit"
                    className="w-full bg-gradient-to-r from-indigo-500 via-violet-500 to-blue-500 text-white py-3 rounded-xl shadow-lg hover:scale-105 hover:shadow-xl transition-all duration-200 font-semibold border-2 border-transparent hover:border-indigo-300 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                  >
                    Save Changes
                  </button>
                </form>
              )}
            </div>
            {/* Account Info Section */}
            <div className="bg-indigo-50/60 rounded-xl p-4 mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
              <div>
                <div className="text-gray-700 text-sm font-medium">Account Created</div>
                <div className="text-lg font-semibold text-indigo-700">
                  {currentUser?.createdAt ? new Date(currentUser.createdAt).toLocaleDateString(undefined, { year: 'numeric', month: 'long', day: 'numeric' }) : 'N/A'}
                </div>
              </div>
              <div>
                <div className="text-gray-700 text-sm font-medium">Last Login</div>
                <div className="text-lg font-semibold text-indigo-700">
                  {currentUser?.lastLogin ? new Date(currentUser.lastLogin).toLocaleString(undefined, { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' }) : 'N/A'}
                </div>
              </div>
            </div>
            {/* Download Data Button */}
            <div className="mb-6">
              <button
                onClick={() => {
                  // Download user data as JSON (excluding password for privacy)
                  const { password, ...safeUser } = currentUser || {};
                  const data = JSON.stringify(safeUser, null, 2);
                  const blob = new Blob([data], { type: 'application/json' });
                  const url = URL.createObjectURL(blob);
                  const a = document.createElement('a');
                  a.href = url;
                  a.download = 'shopwise-profile-data.json';
                  a.click();
                  URL.revokeObjectURL(url);
                }}
                className="w-full bg-gradient-to-r from-indigo-500 via-violet-500 to-blue-500 text-white py-3 rounded-xl shadow-lg hover:scale-105 hover:shadow-xl transition-all duration-200 font-semibold border-2 border-transparent hover:border-indigo-300 focus:outline-none focus:ring-2 focus:ring-indigo-400 flex items-center justify-center gap-2"
              >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={2} stroke="currentColor" className="w-5 h-5">
                  <path strokeLinecap="round" strokeLinejoin="round" d="M12 4v16m0 0l-4-4m4 4l4-4" />
                </svg>
                Download My Data
              </button>
            </div>
            <div className="border-t border-gray-200 pt-4">
              <h3 className="text-lg font-semibold text-gray-800 mb-3">Account Settings</h3>
              <div className="relative">
                <button
                  onClick={handleDeleteAccount}
                  className="w-full bg-red-600 text-white py-3 rounded-lg hover:bg-red-700 transition flex items-center justify-center font-semibold"
                >
                  <Trash2 size={18} className="mr-2" />
                  Delete Account
                </button>
                {/* Delete Account Modal */}
                {showDeleteConfirm && (
                  <div className="fixed inset-0 z-40 flex items-center justify-center bg-black/40 backdrop-blur-sm animate-fade-in">
                    <div className="bg-white rounded-2xl shadow-2xl p-8 max-w-sm w-full flex flex-col items-center border border-gray-200 animate-fade-in-up">
                      <Trash2 size={36} className="text-red-500 mb-3" />
                      <h4 className="text-xl font-bold text-gray-800 mb-2">Delete Account?</h4>
                      <p className="text-gray-600 mb-6 text-center">Are you sure you want to delete your account? This action cannot be undone.</p>
                      <div className="flex gap-4 w-full">
                        <button
                          onClick={handleDeleteConfirm}
                          className="flex-1 py-2 rounded-lg bg-red-600 text-white font-semibold shadow hover:bg-red-700 transition"
                        >
                          Yes, Delete
                        </button>
                        <button
                          onClick={handleDeleteCancel}
                          className="flex-1 py-2 rounded-lg bg-gray-200 text-gray-700 font-semibold shadow hover:bg-gray-300 transition"
                        >
                          No, Cancel
                        </button>
                      </div>
                    </div>
                  </div>
                )}
              </div>
            </div>
          </div>
        </div>
      </div>
      <Footer />
    </div>
  );
};

export default Profile;

/* Add to index.css for animation if not present:
.animate-fade-in { animation: fadeIn 0.3s; }
.animate-fade-in-up { animation: fadeInUp 0.3s; }
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
@keyframes fadeInUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1, transform: translateY(0); } }
*/
