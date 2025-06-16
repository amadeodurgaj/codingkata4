import React from 'react';
import { Link } from 'react-router-dom';
import { products } from '../data/products';
import { formatPrice } from '../lib/utils';

const Home = () => {
  const featuredProducts = products.slice(0, 3);

  return (
    <div>
      {/* Hero Section */}
      <section className="relative h-[600px] flex items-center justify-center">
        <div
          className="absolute inset-0 bg-cover bg-center"
          style={{
            backgroundImage: 'url(https://images.unsplash.com/photo-1576426863848-c21f53c60b19?auto=format&fit=crop&q=80)',
          }}
        >
          <div className="absolute inset-0 bg-black bg-opacity-40" />
        </div>
        <div className="relative text-center text-white px-4">
          <h1 className="text-5xl font-bold mb-4">Discover Your Natural Glow</h1>
          <p className="text-xl mb-8">Clean, effective skincare for your daily routine</p>
          <Link
            to="/products"
            className="bg-white text-primary-900 px-8 py-3 rounded-md font-medium hover:bg-primary-50 transition-colors"
          >
            Shop Now
          </Link>
        </div>
      </section>

      {/* Featured Products */}
      <section className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h2 className="text-3xl font-bold text-primary-900 text-center mb-12">
          Featured Products
        </h2>
        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
          {featuredProducts.map((product) => (
            <Link
              key={product.id}
              to={`/products/${product.id}`}
              className="group"
            >
              <div className="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                <div className="aspect-w-1 aspect-h-1">
                  <img
                    src={product.image}
                    alt={product.name}
                    className="w-full h-64 object-cover"
                  />
                </div>
                <div className="p-6">
                  <h3 className="text-lg font-semibold text-primary-900 mb-2">
                    {product.name}
                  </h3>
                  <p className="text-primary-600 mb-4">{formatPrice(product.price)}</p>
                  <button className="w-full bg-primary-900 text-white py-2 rounded-md hover:bg-primary-800 transition-colors">
                    View Details
                  </button>
                </div>
              </div>
            </Link>
          ))}
        </div>
      </section>

      {/* Benefits Section */}
      <section className="bg-primary-50 py-16">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div>
              <h3 className="text-xl font-semibold text-primary-900 mb-4">
                Natural Ingredients
              </h3>
              <p className="text-primary-600">
                Carefully selected ingredients that work in harmony with your skin
              </p>
            </div>
            <div>
              <h3 className="text-xl font-semibold text-primary-900 mb-4">
                Cruelty Free
              </h3>
              <p className="text-primary-600">
                Never tested on animals, always kind to nature
              </p>
            </div>
            <div>
              <h3 className="text-xl font-semibold text-primary-900 mb-4">
                Science-Backed
              </h3>
              <p className="text-primary-600">
                Formulated with proven active ingredients for real results
              </p>
            </div>
          </div>
        </div>
      </section>
    </div>
  );
};

export default Home;