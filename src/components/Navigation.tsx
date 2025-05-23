import { useState, useEffect } from 'react';
import { Link, useLocation } from 'react-router-dom';
import { House, LogOut, Menu, ShoppingCart, SquarePlus, User, X } from 'lucide-react';
import { useAuth } from '../context/AuthContext';

export const Navigation = () => {
  const { currentUser, logout } = useAuth();
  const location = useLocation();
  const [isMenuOpen, setIsMenuOpen] = useState(false);
  const [scrolled, setScrolled] = useState(false);

  useEffect(() => {
    const link1 = document.createElement('link');
    link1.href = 'https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap';
    link1.rel = 'stylesheet';
    document.head.appendChild(link1);
    
    const link2 = document.createElement('link');
    link2.href = 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap';
    link2.rel = 'stylesheet';
    document.head.appendChild(link2);
    
    const link3 = document.createElement('link');
    link3.href = 'https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&display=swap';
    link3.rel = 'stylesheet';
    document.head.appendChild(link3);
    
    const handleScroll = () => {
      setScrolled(window.scrollY > 10);
    };
    
    window.addEventListener('scroll', handleScroll);
    return () => {
      window.removeEventListener('scroll', handleScroll);
      document.head.removeChild(link1);
      document.head.removeChild(link2);
      document.head.removeChild(link3);
    };
  }, []);

  const handleLogout = () => {
    logout();
  };

  const isActive = (path: string) => {
    return location.pathname === path;
  };

  return (
    <nav className={`sticky top-0 z-50 transition-all duration-300 ${
      scrolled 
        ? 'bg-white/80 shadow-md backdrop-blur-md border-b border-white/20' 
        : 'bg-white/70 backdrop-blur-sm border-b border-gray-200/70'
    }`}>
      {/* Updated container with same padding as Welcome page */}
      <div className="max-w-7xl mx-auto px-8 py-6">
        <div className="flex justify-between items-center">
          {/* Updated logo to match Welcome page sizing */}
          <div className="flex items-center gap-2">
            <Link to="/" className="flex items-center gap-2">
              <div className="p-2 bg-gradient-to-br from-indigo-600 to-violet-600 rounded-lg shadow-lg">
                <ShoppingCart className="text-white" size={24} />
              </div>
              <span className="font-bold text-2xl gradient-text" style={{ fontFamily: "'Outfit', sans-serif" }}>
                ShopWise
              </span>
            </Link>
          </div>

          {/* Desktop navigation */}
          <div className="hidden md:flex items-center gap-4">
            {currentUser ? (
              <>
                {/* Dashboard */}
                <Link 
                  to="/dashboard" 
                  className={`flex items-center gap-2 px-3 py-2 rounded-md text-sm font-medium ${
                    isActive('/dashboard') 
                      ? 'text-indigo-700 bg-indigo-50' 
                      : 'text-gray-700 hover:text-indigo-600 hover:bg-indigo-50/80'
                  }`}
                >
                  <House size={18} />
                  Dashboard
                </Link>

                {/* New List */}
                <Link 
                  to="/new-list" 
                  className={`flex items-center gap-2 px-3 py-2 rounded-md text-sm font-medium ${
                    isActive('/new-list') 
                      ? 'text-indigo-700 bg-indigo-50' 
                      : 'text-gray-700 hover:text-indigo-600 hover:bg-indigo-50/80'
                  }`}
                >
                  <SquarePlus size={18} />
                  New List
                </Link>

                {/* Logout */}
                <button
                  onClick={handleLogout}
                  className="flex items-center gap-2 px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-200"
                >
                  <LogOut size={18} />
                  Logout
                </button>

                {/* User Profile */}
                <div className="flex items-center ml-4 pl-4 border-l border-gray-200">
                  <Link 
                    to="/profile"
                    className="flex items-center bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full hover:bg-indigo-100 transition"
                  >
                    {currentUser?.photoURL ? (
                      <img 
                        src={currentUser.photoURL} 
                        alt="Profile" 
                        className="w-8 h-8 rounded-full object-cover mr-2"
                      />
                    ) : (
                      <User size={18} className="mr-1 text-indigo-600" />
                    )}
                    <span className="text-sm font-medium">
                      {currentUser.name}
                    </span>
                  </Link>
                </div>
              </>
            ) : (
              <>
                {/* Updated login/signup buttons to match Welcome page */}
                <Link 
                  to="/login" 
                  className="py-2 px-4 rounded-lg text-indigo-600 font-medium hover:bg-white hover:shadow-sm transition duration-300"
                >
                  Login
                </Link>
                <Link 
                  to="/register" 
                  className="py-2 px-5 bg-gradient-to-r from-indigo-600 to-violet-600 text-white rounded-lg font-medium hover:shadow-md hover:translate-y-[-2px] active:translate-y-[0px] transition duration-300 flex items-center gap-1"
                >
                  <span>Sign Up</span>
                </Link>
              </>
            )}
          </div>

          {/* Mobile menu button */}
          <div className="flex items-center md:hidden">
            <button
              onClick={() => setIsMenuOpen(!isMenuOpen)}
              className="p-2 rounded-md text-gray-500 hover:bg-gray-100 focus:outline-none"
            >
              {isMenuOpen ? <X size={24} /> : <Menu size={24} />}
            </button>
          </div>
        </div>
      </div>

      {/* Mobile menu (unchanged) */}
      {isMenuOpen && (
        <div className="md:hidden">
          <div className="pt-2 pb-4 space-y-1 px-4">
            {currentUser ? (
              <>
                <div className="px-3 py-3 border-b border-gray-200 mb-2 flex items-center gap-3">
                  {currentUser?.photoURL ? (
                    <img 
                      src={currentUser.photoURL} 
                      alt="Profile" 
                      className="w-12 h-12 rounded-full object-cover"
                    />
                  ) : (
                    <div className="p-2 bg-indigo-100 rounded-full">
                      <User size={24} className="text-indigo-600" />
                    </div>
                  )}
                  <div>
                    <p className="text-sm font-medium text-gray-700">Signed in as</p>
                    <p className="text-sm text-gray-600">{currentUser.email}</p>
                  </div>
                </div>
                <Link
                  to="/dashboard"
                  className="flex items-center gap-2 px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100"
                  onClick={() => setIsMenuOpen(false)}
                >
                  <House size={18} />
                  Dashboard
                </Link>
                <Link
                  to="/new-list"
                  className="flex items-center gap-2 px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100"
                  onClick={() => setIsMenuOpen(false)}
                >
                  <SquarePlus size={18} />
                  New List
                </Link>
                <Link
                  to="/profile"
                  className="flex items-center gap-2 px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100"
                  onClick={() => setIsMenuOpen(false)}
                >
                  <User size={18} />
                  My Profile
                </Link>
                <button
                  onClick={() => {
                    handleLogout();
                    setIsMenuOpen(false);
                  }}
                  className="flex items-center gap-2 w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100"
                >
                  <LogOut size={18} />
                  Logout
                </button>
              </>
            ) : (
              <>
                <Link
                  to="/login"
                  className="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100"
                  onClick={() => setIsMenuOpen(false)}
                >
                  Login
                </Link>
                <Link
                  to="/register"
                  className="block px-3 py-2 rounded-md text-base font-medium bg-gradient-to-r from-indigo-600 to-violet-600 text-white hover:bg-indigo-700"
                  onClick={() => setIsMenuOpen(false)}
                >
                  Sign Up
                </Link>
              </>
            )}
          </div>
        </div>
      )}
    </nav>
  );
};
