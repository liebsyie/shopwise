import React from 'react';

interface ModalProps {
  isOpen: boolean;
  onClose: () => void;
  children: React.ReactNode;
  title?: string;
}

const Modal: React.FC<ModalProps> = ({ isOpen, onClose, children, title }) => {
  if (!isOpen) return null;
  return (
    <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm animate-fade-in">
      <div className="bg-white/90 rounded-2xl shadow-2xl max-w-2xl w-full p-8 relative border border-white/40 ring-1 ring-indigo-100 animate-fade-in-up">
        <button
          onClick={onClose}
          className="absolute top-4 right-4 text-gray-500 hover:text-indigo-600 text-xl font-bold rounded-full p-2 transition"
          aria-label="Close"
        >
          ×
        </button>
        {title && <h2 className="text-2xl font-bold text-indigo-700 mb-4 text-center">{title}</h2>}
        <div>{children}</div>
      </div>
    </div>
  );
};

export default Modal;
