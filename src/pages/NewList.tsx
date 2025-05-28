import { useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { Formik, Form, Field, ErrorMessage } from 'formik';
import * as Yup from 'yup';
import { Navigation } from '../components/Navigation';
import { useList } from '../context/ListContext';
import { ShoppingBag } from 'lucide-react';
import Footer from '../components/Footer';

const NewList = () => {
  const { createList } = useList();
  const navigate = useNavigate();
  
  useEffect(() => {
    const link = document.createElement('link');
    link.href = 'https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Montserrat:wght@700;800&display=swap';
    link.rel = 'stylesheet';
    document.head.appendChild(link);
    
    return () => {
      document.head.removeChild(link);
    };
  }, []);

  const validationSchema = Yup.object({
    name: Yup.string().required('List name is required'),
    budget: Yup.number()
      .required('Budget is required')
      .positive('Budget must be a positive number')
      .typeError('Budget must be a number'),
    description: Yup.string(),
  });

  const handleSubmit = (values: { name: string; budget: string | number }) => {
    const budget = typeof values.budget === 'string' ? parseFloat(values.budget) : values.budget;
    createList(values.name, budget);
    navigate('/dashboard');
  };

  return (
    <div className="flex flex-col min-h-screen font-[Outfit,sans-serif] bg-gradient-to-br from-indigo-100 via-blue-50 to-violet-100">
      <div className="fixed inset-0 -z-10 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-indigo-200/60 via-slate-100/40 to-blue-100/50"></div>
      <div className="fixed inset-0 -z-10 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-[0.13]"></div>
      <Navigation />
      <div className="flex-1 flex items-center justify-center">
        <div className="container mx-auto px-4 py-12">
          <div className="max-w-xl mx-auto bg-white/60 backdrop-blur-2xl rounded-2xl shadow-xl border border-white/40 ring-1 ring-indigo-100 p-8 animate-fade-in">
            <div className="flex items-center gap-3 mb-8 justify-center">
              <ShoppingBag className="text-indigo-500 drop-shadow-lg" size={32} />
              <h1 className="text-2xl md:text-3xl font-extrabold text-gray-800 tracking-tight drop-shadow-sm" style={{ fontFamily: "'Outfit', 'Montserrat', sans-serif" }}>
                Create New Shopping List
              </h1>
            </div>
            <Formik
              initialValues={{ name: '', budget: '', description: '' }}
              validationSchema={validationSchema}
              onSubmit={(values) => handleSubmit({ 
                name: values.name, 
                budget: parseFloat(values.budget as unknown as string) 
              })}
            >
              {({ isSubmitting }) => (
                <Form>
                  <div className="mb-4">
                    <label htmlFor="name" className="block text-gray-700 font-semibold mb-1">
                      List Name
                    </label>
                    <Field
                      type="text"
                      name="name"
                      id="name"
                      placeholder="Weekly Groceries"
                      className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none transition bg-white/80 shadow-sm hover:shadow-md"
                    />
                    <ErrorMessage name="name" component="div" className="text-red-500 text-sm mt-1" />
                  </div>
                  <div className="mb-4">
                    <label htmlFor="budget" className="block text-gray-700 font-semibold mb-1">
                      Budget
                    </label>
                    <div className="relative">
                      <div className="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <span className="text-gray-500">₱</span>
                      </div>
                      <Field
                        type="number"
                        name="budget"
                        id="budget"
                        placeholder="100.00"
                        step="0.01"
                        min="0"
                        className="w-full pl-8 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none transition bg-white/80 shadow-sm hover:shadow-md"
                      />
                    </div>
                    <ErrorMessage name="budget" component="div" className="text-red-500 text-sm mt-1" />
                  </div>
                  <div className="mb-6">
                    <label htmlFor="description" className="block text-gray-700 font-medium mb-2">
                      Description (Optional)
                    </label>
                    <Field
                      as="textarea"
                      name="description"
                      id="description"
                      rows={3}
                      placeholder="Add notes about this shopping list"
                      className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none transition bg-white/80 shadow-sm hover:shadow-md"
                    />
                  </div>
                  <div className="flex gap-4">
                    <button
                      type="button"
                      onClick={() => navigate('/dashboard')}
                      className="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition"
                    >
                      Cancel
                    </button>
                    <button
                      type="submit"
                      disabled={isSubmitting}
                      className="px-4 py-2 bg-gradient-to-r from-indigo-500 via-violet-500 to-blue-500 text-white rounded-xl shadow-lg hover:scale-105 hover:shadow-xl transition-all duration-200 font-semibold border-2 border-transparent hover:border-indigo-300 focus:outline-none focus:ring-2 focus:ring-indigo-400 flex-1"
                    >
                      Create List
                    </button>
                  </div>
                </Form>
              )}
            </Formik>
          </div>
        </div>
      </div>
      <Footer />
    </div>
  );
};

export default NewList;
