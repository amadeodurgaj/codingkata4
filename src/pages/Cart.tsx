import React from 'react';
import { Link } from 'react-router-dom';
import { Trash2 } from 'lucide-react';
import { useCartStore } from '../store/cart';
import { formatPrice } from '../lib/utils';

const Cart = () => {
  const cartItems = useCartStore((state) => state.items);
  const subtotal = cartItems.reduce((total, item) => total + (item.product.price * item.quantity), 0);
  const shipping = 5.00;
  const total = subtotal + shipping;

  if (cartItems.length === 0) {
    return (
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div className="text-center">
          <h2 className="text-2xl font-semibold text-primary-900 mb-4">Your cart is empty</h2>
          <p className="text-primary-600 mb-8">Discover our collection of premium skincare products.</p>
          <Link
            to="/products"
            className="inline-block bg-primary-900 text-white px-8 py-3 rounded-md hover:bg-primary-800 transition-colors"
          >
            Shop Now
          </Link>
        </div>
      </div>
    );
  }

  return (
    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <h1 className="text-3xl font-bold text-primary-900 mb-8">Shopping Cart</h1>

      <div className="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <div className="lg:col-span-2">
          <div className="space-y-6">
            {cartItems.map((item) => (
              <div
                key={item.product.id}
                className="flex gap-6 bg-white p-6 rounded-lg shadow-sm"
              >
                <img
                  src={item.product.image}
                  alt={item.product.name}
                  className="w-24 h-24 object-cover rounded-md"
                />
                <div className="flex-grow">
                  <h3 className="text-lg font-semibold text-primary-900">
                    {item.product.name}
                  </h3>
                  <p className="text-primary-600 mb-2">{item.product.category}</p>
                  <p className="font-medium text-primary-900">
                    {formatPrice(item.product.price)}
                  </p>
                </div>
                <div className="flex flex-col items-end justify-between">
                  <button className="text-primary-600 hover:text-primary-900">
                    <Trash2 className="h-5 w-5" />
                  </button>
                  <select
                    value={item.quantity}
                    className="border border-primary-200 rounded-md px-2 py-1"
                  >
                    {[1, 2, 3, 4, 5].map((num) => (
                      <option key={num} value={num}>
                        {num}
                      </option>
                    ))}
                  </select>
                </div>
              </div>
            ))}
          </div>
        </div>

        <div className="bg-white p-6 rounded-lg shadow-sm h-fit">
          <h2 className="text-xl font-semibold text-primary-900 mb-6">Order Summary</h2>
          <div className="space-y-4">
            <div className="flex justify-between text-primary-600">
              <span>Subtotal</span>
              <span>{formatPrice(subtotal)}</span>
            </div>
            <div className="flex justify-between text-primary-600">
              <span>Shipping</span>
              <span>{formatPrice(shipping)}</span>
            </div>
            <div className="border-t border-primary-200 pt-4">
              <div className="flex justify-between text-lg font-semibold text-primary-900">
                <span>Total</span>
                <span>{formatPrice(total)}</span>
              </div>
            </div>
          </div>
          <button className="w-full bg-primary-900 text-white py-3 rounded-md hover:bg-primary-800 transition-colors mt-6">
            Proceed to Checkout
          </button>
        </div>
      </div>
    </div>
  );
};

export default Cart;