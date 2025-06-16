import React from 'react';
import { Link } from 'react-router-dom';
import { ShoppingCart, Menu, Search } from 'lucide-react';
import { useCartStore } from '../store/cart';

const Navbar = () => {
  const cartItems = useCartStore((state) => state.items);
  const itemCount = cartItems.reduce((acc, item) => acc + item.quantity, 0);

  return (
    <nav className="bg-white shadow-sm">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex justify-between h-16">
          <div className="flex items-center">
            <Link to="/" className="flex-shrink-0 flex items-center">
              <span className="text-2xl font-semibold text-primary-900">Lumora</span>
            </Link>
          </div>

          <div className="hidden sm:ml-6 sm:flex sm:items-center sm:space-x-8">
            <Link to="/" className="text-primary-700 hover:text-primary-900 px-3 py-2">
              Home
            </Link>
            <Link to="/products" className="text-primary-700 hover:text-primary-900 px-3 py-2">
              Products
            </Link>
            <button className="text-primary-700 hover:text-primary-900">
              <Search className="h-5 w-5" />
            </button>
            <Link to="/cart" className="text-primary-700 hover:text-primary-900 relative">
              <ShoppingCart className="h-5 w-5" />
              {itemCount > 0 && (
                <span className="absolute -top-2 -right-2 bg-accent-500 text-white rounded-full text-xs w-5 h-5 flex items-center justify-center">
                  {itemCount}
                </span>
              )}
            </Link>
          </div>

          <div className="sm:hidden flex items-center">
            <button className="text-primary-700 hover:text-primary-900">
              <Menu className="h-6 w-6" />
            </button>
          </div>
        </div>
      </div>
    </nav>
  );
};

export default Navbar;