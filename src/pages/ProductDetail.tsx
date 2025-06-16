import React from 'react';
import { useParams } from 'react-router-dom';
import { products } from '../data/products';
import { formatPrice } from '../lib/utils';
import { Plus, Minus } from 'lucide-react';

const ProductDetail = () => {
  const { id } = useParams();
  const product = products.find((p) => p.id === id);

  if (!product) {
    return (
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <p className="text-xl text-primary-900">Product not found</p>
      </div>
    );
  }

  return (
    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div className="grid grid-cols-1 md:grid-cols-2 gap-12">
        <div className="relative">
          <img
            src={product.image}
            alt={product.name}
            className="w-full h-[500px] object-cover rounded-lg"
          />
        </div>

        <div>
          <h1 className="text-3xl font-bold text-primary-900 mb-4">{product.name}</h1>
          <p className="text-2xl font-semibold text-primary-900 mb-6">
            {formatPrice(product.price)}
          </p>
          
          <div className="mb-8">
            <p className="text-primary-600 leading-relaxed mb-4">
              {product.description}
            </p>
          </div>

          <div className="mb-8">
            <h3 className="text-lg font-semibold text-primary-900 mb-3">Key Ingredients</h3>
            <ul className="list-disc list-inside space-y-2 text-primary-600">
              {product.ingredients.map((ingredient, index) => (
                <li key={index}>{ingredient}</li>
              ))}
            </ul>
          </div>

          <div className="flex items-center gap-4 mb-6">
            <button className="p-2 border border-primary-200 rounded-md">
              <Minus className="h-4 w-4 text-primary-600" />
            </button>
            <span className="text-lg font-medium text-primary-900">1</span>
            <button className="p-2 border border-primary-200 rounded-md">
              <Plus className="h-4 w-4 text-primary-600" />
            </button>
          </div>

          <button className="w-full bg-primary-900 text-white py-3 rounded-md hover:bg-primary-800 transition-colors">
            Add to Cart
          </button>
        </div>
      </div>
    </div>
  );
};

export default ProductDetail;