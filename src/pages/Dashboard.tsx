import { useEffect } from 'react';
import { Link } from 'react-router-dom';
import { Navigation } from '../components/Navigation';
import { useList } from '../context/ListContext';
import { Calendar, CirclePlus, ShoppingBag } from 'lucide-react';
import Footer from '../components/Footer';

const Dashboard = () => {
  const { lists, setCurrentList } = useList();
  
  useEffect(() => {
    const link = document.createElement('link');
    link.href = 'https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Montserrat:wght@700;800&display=swap';
    link.rel = 'stylesheet';
    document.head.appendChild(link);
    
    return () => {
      document.head.removeChild(link);
    };
  }, []);
  
  const formatDate = (dateString: string) => {
    const options: Intl.DateTimeFormatOptions = { year: 'numeric', month: 'short', day: 'numeric' };
    return new Date(dateString).toLocaleDateString(undefined, options);
  };

  const calculateTotal = (listId: string) => {
    const list = lists.find(l => l.id === listId);
    if (!list) return 0;
    
    return list.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
  };

  const getBudgetStatus = (listId: string) => {
    const list = lists.find(l => l.id === listId);
    if (!list) return { color: 'gray', text: 'Unknown' };
    
    const spent = calculateTotal(listId);
    const budget = list.budget;
    const percentage = (spent / budget) * 100;
    
    if (percentage >= 100) return { color: 'red', text: 'Over Budget' };
    if (percentage >= 80) return { color: 'yellow', text: 'Near Limit' };
    return { color: 'green', text: 'On Track' };
  };

  return (
    <div className="flex flex-col min-h-screen font-[Outfit,sans-serif] bg-gradient-to-br from-indigo-100 via-blue-50 to-violet-100">
      <Navigation />
      <div className="flex-1">
        <div className="container mx-auto px-4 py-8">
          <div className="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
            <h1 className="text-3xl font-extrabold tracking-tight drop-shadow-sm text-indigo-600 hover:text-indigo-800 transition font-semibold" style={{ fontFamily: "'Outfit', 'Montserrat', sans-serif" }}>
              My Shopping Lists
            </h1>
            <Link
              to="/new-list"
              className="flex items-center gap-2 bg-gradient-to-r from-indigo-500 via-violet-500 to-blue-500 text-white px-5 py-2 rounded-xl shadow-lg hover:scale-105 hover:shadow-xl transition-all duration-200 border-2 border-transparent hover:border-indigo-300 focus:outline-none focus:ring-2 focus:ring-indigo-400"
            >
              <CirclePlus size={22} />
              <span className="font-semibold tracking-wide">New List</span>
            </Link>
          </div>
          {lists.length === 0 ? (
            <div className="bg-white/60 backdrop-blur-2xl rounded-2xl shadow-xl p-10 text-center border border-white/40 ring-1 ring-indigo-100 animate-fade-in">
              <ShoppingBag className="mx-auto text-indigo-400 mb-4 drop-shadow-lg" size={56} />
              <h2 className="text-2xl font-bold text-gray-700 mb-2">No shopping lists yet</h2>
              <p className="text-gray-500 mb-6">Create your first shopping list to start tracking your grocery budget</p>
              <Link
                to="/new-list"
                className="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-500 via-violet-500 to-blue-500 text-white px-5 py-2 rounded-xl shadow-lg hover:scale-105 hover:shadow-xl transition-all duration-200 border-2 border-transparent hover:border-indigo-300 focus:outline-none focus:ring-2 focus:ring-indigo-400"
              >
                <CirclePlus size={20} />
                Create Shopping List
              </Link>
            </div>
          ) : (
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
              {lists.map(list => {
                const budgetStatus = getBudgetStatus(list.id);
                const total = calculateTotal(list.id);
                const percentage = Math.min(100, Math.round((total / list.budget) * 100));
                return (
                  <div key={list.id} className="relative group bg-white/60 backdrop-blur-2xl rounded-2xl shadow-xl overflow-hidden border border-white/40 ring-1 ring-indigo-100 hover:scale-[1.03] hover:shadow-2xl transition-all duration-200 animate-fade-in">
                    <div className="absolute -inset-0.5 bg-gradient-to-br from-indigo-200/40 via-violet-200/30 to-blue-200/40 blur-xl opacity-60 group-hover:opacity-80 pointer-events-none z-0"></div>
                    <div className="relative p-7 z-10">
                      <h3 className="text-xl font-bold text-gray-800 mb-2 tracking-tight" style={{ fontFamily: "'Montserrat', 'Outfit', sans-serif" }}>{list.name}</h3>
                      <div className="flex items-center gap-2 text-gray-500 text-sm mb-4">
                        <Calendar size={16} />
                        <span>{formatDate(list.createdAt)}</span>
                      </div>
                      <div className="mb-4">
                        <div className="flex justify-between text-sm mb-1">
                          <span className="text-gray-600">Budget: ₱{list.budget.toFixed(2)}</span>
                          <span className="font-medium">
                            ₱{total.toFixed(2)} ({percentage}%)
                          </span>
                        </div>
                        <div className="w-full bg-gray-200/60 rounded-full h-2.5">
                          <div 
                            className={`h-2.5 rounded-full transition-all duration-300 ${
                              budgetStatus.color === 'green' ? 'bg-gradient-to-r from-green-400 to-green-600' : 
                              budgetStatus.color === 'yellow' ? 'bg-gradient-to-r from-yellow-400 to-yellow-600' : 
                              'bg-gradient-to-r from-red-400 to-red-600'
                            }`}
                            style={{ width: `${percentage}%` }}
                          ></div>
                        </div>
                      </div>
                      <div className="flex justify-between items-center mt-4">
                        <div className="flex items-center gap-1.5">
                          <span className="text-gray-400">₱</span>
                          <span className="text-sm text-gray-500">
                            {list.items.length} items
                          </span>
                        </div>
                        <Link
                          to={`/list/${list.id}`}
                          className="px-4 py-1.5 bg-blue-50/80 text-blue-700 rounded-lg text-sm font-semibold hover:bg-blue-100/90 transition border border-blue-100 shadow-sm hover:scale-105"
                          onClick={() => setCurrentList(list.id)}
                        >
                          View Details
                        </Link>
                      </div>
                    </div>
                  </div>
                );
              })}
            </div>
          )}
        </div>
      </div>
      <Footer />
    </div>
  );
};

export default Dashboard;
