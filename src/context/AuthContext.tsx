import React, { createContext, useState, useContext, useEffect } from 'react';
import { User } from '../types';
import { useNavigate, useLocation } from 'react-router-dom';

interface AuthContextType {
  currentUser: User | null;
  login: (email: string, password: string) => Promise<void>;
  register: (name: string, email: string, password: string) => Promise<void>;
  logout: () => void;
  isAuthenticated: boolean;
  updateProfile: (updates: { name?: string; photoURL?: string }) => Promise<void>;
  deleteAccount: () => Promise<void>;
}

const AuthContext = createContext<AuthContextType | undefined>(undefined);

export const useAuth = () => {
  const context = useContext(AuthContext);
  if (context === undefined) {
    throw new Error('useAuth must be used within an AuthProvider');
  }
  return context;
};

// Utility function to hash a string using SHA-256 and return hex
async function hashPassword(password: string): Promise<string> {
  const encoder = new TextEncoder();
  const data = encoder.encode(password);
  const hashBuffer = await window.crypto.subtle.digest('SHA-256', data);
  return Array.from(new Uint8Array(hashBuffer))
    .map(b => b.toString(16).padStart(2, '0'))
    .join('');
}

const AuthStateManager: React.FC<{ children: React.ReactNode }> = ({ children }) => {
  const [currentUser, setCurrentUser] = useState<User | null>(null);
  const [isAuthenticated, setIsAuthenticated] = useState<boolean>(false);
  const navigate = useNavigate();
  const location = useLocation();

  useEffect(() => {
    const storedUser = localStorage.getItem('shopwise_user');
    const users = JSON.parse(localStorage.getItem('shopwise_users') || '[]');
    
    if (storedUser) {
      const user = JSON.parse(storedUser);
      const validUser = users.find((u: User) => u.email === user.email);
      if (validUser) {
        setCurrentUser(validUser);
        setIsAuthenticated(true);
        if (!localStorage.getItem(`shopwise_lists_${validUser.id}`)) {
          localStorage.setItem(`shopwise_lists_${validUser.id}`, '[]');
        }
        return;
      }
    }

    const isAuthRoute = ['/login', '/register', '/'].some(path => 
      location.pathname.includes(path)
    );
    
    if (!isAuthRoute) navigate('/login', { replace: true });
  }, [navigate, location.pathname]);

  const login = async (email: string, password: string) => {
    const users: User[] = JSON.parse(localStorage.getItem('shopwise_users') || '[]');
    const hashedPassword = await hashPassword(password);
    const user = users.find(u => u.email === email && u.password === hashedPassword);

    if (!user) throw new Error('Invalid email or password');
    // Update lastLogin on login
    user.lastLogin = new Date().toISOString();
    // Update users array in localStorage
    const updatedUsers = users.map(u => u.id === user.id ? { ...u, lastLogin: user.lastLogin } : u);
    localStorage.setItem('shopwise_users', JSON.stringify(updatedUsers));
    localStorage.setItem('shopwise_user', JSON.stringify(user));
    setCurrentUser(user);
    setIsAuthenticated(true);
    navigate('/dashboard', { replace: true });
  };

  const register = async (name: string, email: string, password: string) => {
    const users: User[] = JSON.parse(localStorage.getItem('shopwise_users') || '[]');
    
    if (users.some(u => u.email === email)) {
      throw new Error('Email already registered');
    }

    const hashedPassword = await hashPassword(password);
    const user: User = {
      id: Date.now().toString(),
      name,
      email,
      password: hashedPassword,
      photoURL: '',
      createdAt: new Date().toISOString(),
      lastLogin: new Date().toISOString(),
    };

    localStorage.setItem('shopwise_users', JSON.stringify([...users, user]));
    localStorage.setItem('shopwise_user', JSON.stringify(user));
    localStorage.setItem(`shopwise_lists_${user.id}`, '[]');
    setCurrentUser(user);
    setIsAuthenticated(true);
    navigate('/dashboard', { replace: true });
  };

  const logout = () => {
    localStorage.removeItem('shopwise_user');
    setCurrentUser(null);
    setIsAuthenticated(false);
    navigate('/', { replace: true });
  };

  const updateProfile = async (updates: { name?: string; photoURL?: string }) => {
    if (!currentUser) throw new Error('No user logged in');

    const users: User[] = JSON.parse(localStorage.getItem('shopwise_users') || '[]');
    let newPhotoURL = updates.photoURL;
    // Accept both data URLs and valid image URLs
    if (newPhotoURL && !newPhotoURL.startsWith('data:') && !/^https?:\/\//.test(newPhotoURL)) {
      // If not a data URL or http(s) URL, try to resolve as a relative path
      newPhotoURL = window.location.origin + '/' + newPhotoURL.replace(/^\/*/, '');
    }

    const updatedUser = {
      ...currentUser,
      name: updates.name !== undefined ? updates.name : currentUser.name,
      photoURL: newPhotoURL !== undefined ? newPhotoURL : currentUser.photoURL
    };

    const updatedUsers = users.map(u => 
      u.id === currentUser.id ? updatedUser : u
    );

    localStorage.setItem('shopwise_users', JSON.stringify(updatedUsers));
    localStorage.setItem('shopwise_user', JSON.stringify(updatedUser));
    setCurrentUser(updatedUser);
  };

  const deleteAccount = async () => {
    if (!currentUser) return;

    const users: User[] = JSON.parse(localStorage.getItem('shopwise_users') || '[]');
    const updatedUsers = users.filter(u => u.id !== currentUser.id);

    localStorage.setItem('shopwise_users', JSON.stringify(updatedUsers));
    localStorage.removeItem('shopwise_user');
    localStorage.removeItem(`shopwise_lists_${currentUser.id}`);
    setCurrentUser(null);
    setIsAuthenticated(false);
  };

  return (
    <AuthContext.Provider value={{ 
      currentUser, 
      login, 
      register, 
      logout, 
      isAuthenticated,
      updateProfile,
      deleteAccount
    }}>
      {children}
    </AuthContext.Provider>
  );
};

export const AuthProvider: React.FC<{ children: React.ReactNode }> = ({ children }) => {
  return <AuthStateManager>{children}</AuthStateManager>;
};
