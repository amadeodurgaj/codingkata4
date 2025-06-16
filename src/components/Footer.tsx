import React from 'react';
import { Instagram, Facebook, Twitter } from 'lucide-react';

const Footer = () => {
  return (
    <footer className="bg-white">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div className="grid grid-cols-1 md:grid-cols-4 gap-8">
          <div>
            <h3 className="text-lg font-semibold text-primary-900 mb-4">About Lumora</h3>
            <p className="text-primary-600">
              Discover the power of natural skincare with Lumora's premium products.
            </p>
          </div>
          <div>
            <h3 className="text-lg font-semibold text-primary-900 mb-4">Quick Links</h3>
            <ul className="space-y-2">
              <li><a href="#" className="text-primary-600 hover:text-primary-900">About Us</a></li>
              <li><a href="#" className="text-primary-600 hover:text-primary-900">Contact</a></li>
              <li><a href="#" className="text-primary-600 hover:text-primary-900">Shipping</a></li>
              <li><a href="#" className="text-primary-600 hover:text-primary-900">Returns</a></li>
            </ul>
          </div>
          <div>
            <h3 className="text-lg font-semibold text-primary-900 mb-4">Customer Care</h3>
            <ul className="space-y-2">
              <li><a href="#" className="text-primary-600 hover:text-primary-900">FAQ</a></li>
              <li><a href="#" className="text-primary-600 hover:text-primary-900">Track Order</a></li>
              <li><a href="#" className="text-primary-600 hover:text-primary-900">Privacy Policy</a></li>
              <li><a href="#" className="text-primary-600 hover:text-primary-900">Terms of Service</a></li>
            </ul>
          </div>
          <div>
            <h3 className="text-lg font-semibold text-primary-900 mb-4">Connect With Us</h3>
            <div className="flex space-x-4">
              <a href="#" className="text-primary-600 hover:text-primary-900">
                <Instagram className="h-6 w-6" />
              </a>
              <a href="#" className="text-primary-600 hover:text-primary-900">
                <Facebook className="h-6 w-6" />
              </a>
              <a href="#" className="text-primary-600 hover:text-primary-900">
                <Twitter className="h-6 w-6" />
              </a>
            </div>
          </div>
        </div>
        <div className="mt-8 pt-8 border-t border-primary-200">
          <p className="text-center text-primary-600">
            © {new Date().getFullYear()} Lumora. All rights reserved.
          </p>
        </div>
      </div>
    </footer>
  );
};

export default Footer;