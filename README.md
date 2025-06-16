# Lumora Skincare E-Commerce

Lumora is a premium skincare e-commerce application built with React. The project features a responsive design with a modern UI using Tailwind CSS, efficient state management with Zustand (with persistent storage), and client-side routing via React Router. It allows users to browse featured products, view product details, and manage a shopping cart.

---

## Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Installation](#installation)
- [Project Structure](#project-structure)
- [Notes](#notes)
- [License](#license)

---

## Features

- **Product Listing:** Browse a range of skincare products with images, prices, and descriptions.
- **Product Details:** Detailed view of individual products including key ingredients and quantity selection.
- **Shopping Cart:** Add, remove, and update quantities of products in the cart with a running order summary.
- **Persistent Cart:** Cart state is maintained across sessions using Zustand's persist middleware.
- **Responsive Navigation:** A dynamic Navbar and Footer with social media integration and mobile support.
- **Utility Functions:** Includes helper functions for merging Tailwind class names and formatting prices.

---

## Tech Stack

- **React:** UI library for building the user interface.
- **React Router:** For client-side routing and navigation.
- **Tailwind CSS:** Utility-first CSS framework for rapid UI development.
- **Zustand:** Lightweight state management library with middleware support.
- **Lucide React:** Icon library for modern and scalable icons.
- **TypeScript:** Provides static type checking for safer code (if your project uses TS).

---

## Installation

1. **Clone the repository:**

   ```bash
   git clone https://github.com/yourusername/lumora-ecommerce.git
   cd lumora-ecommerce
   ```

2. **Install dependencies:**

   ```bash
   npm install
    ```
    or
    ```bash
    yarn install
   ```

3. **Start the development server:**

   ```bash
   npm start
    ```
    or
    ```bash
    yarn start
   ```

## Project Structure

```
/src
 ├── components
 │    ├── Navbar.tsx          // Navigation bar with cart badge and mobile support
 │    └── Footer.tsx          // Footer with quick links and social media icons
 │
 ├── data
 │    └── products.ts         // Array of product objects with details and imported images
 │
 ├── lib
 │    └── utils.ts            // Utility functions (cn for class merging, formatPrice for price formatting)
 │
 ├── pages
 │    ├── Home.tsx            // Landing page with hero section and featured products
 │    ├── Products.tsx        // Product listing page with filtering options
 │    ├── ProductDetail.tsx   // Product detail page with key ingredients and add-to-cart
 │    └── Cart.tsx            // Shopping cart page with order summary
 │
 ├── store
 │    └── cart.ts             // Zustand store for managing and persisting the cart state
 │
 ├── img                     // Directory for image assets imported in products.ts
 │    ├── cleanser.jpeg
 │    ├── darkspot.png
 │    ├── moisturizer.png
 │    ├── eyeserum.png
 │    ├── hydratingtoner.png
 │    └── lipmask.png
 │
 └── App.tsx                 // Main app component handling routing with React Router
```

## Notes

The page is meant for UI purposes only, the functionality is not implemented and is not intended to be implemented.

## License

This project is open source and available under the MIT License.