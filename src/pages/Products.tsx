import React from 'react';
import { Link } from 'react-router-dom';
import { products } from '../data/products';
import { formatPrice } from '../lib/utils';

const Products = () => {
  return (
    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div className="flex justify-between items-center mb-8">
        <h1 className="text-3xl font-bold text-primary-900">All Products</h1>
        <div className="flex gap-4">
          <select className="px-4 py-2 border border-primary-200 rounded-md text-primary-700">
            <option value="">Category</option>
            <option value="cleanser">Cleanser</option>
            <option value="serum">Serum</option>
            <option value="moisturizer">Moisturizer</option>
          </select>
          <select className="px-4 py-2 border border-primary-200 rounded-md text-primary-700">
            <option value="">Sort by</option>
            <option value="price-low">Price: Low to High</option>
            <option value="price-high">Price: High to Low</option>
            <option value="name">Name</option>
          </select>
        </div>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        {products.map((product) => (
          <Link
            key={product.id}
            to={`/products/${product.id}`}
            className="group bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-all"
          >
            <div className="aspect-w-1 aspect-h-1">
              <img
                src={product.image}
                alt={product.name}
                className="w-full h-64 object-cover"
              />
            </div>
            <div className="p-6">
              <h2 className="text-lg font-semibold text-primary-900 mb-2">
                {product.name}
              </h2>
              <p className="text-primary-600 mb-2">{product.category}</p>
              <p className="text-xl font-medium text-primary-900">
                {formatPrice(product.price)}
              </p>
              <button className="mt-4 w-full bg-primary-900 text-white py-2 rounded-md hover:bg-primary-800 transition-colors">
                View Details
              </button>
            </div>
          </Link>
        ))}
      </div>
    </div>
  );
};

export default Products;