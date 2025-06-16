export interface Product {
  id: string;
  name: string;
  price: number;
  description: string;
  ingredients: string[];
  image: string;
  category: string;
}

export interface CartItem {
  product: Product;
  quantity: number;
}