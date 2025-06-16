import cleanserImage from "../img/cleanser.jpeg"
import darkspotImage from "../img/darkspot.png"
import moisturizerImage from "../img/moisturizer.png"
import serumImage from "../img/eyeserum.png"
import tonerImage from "../img/hydratingtoner.png"
import maskImage from "../img/lipmask.png"

export const products = [
  {
    id: '1',
    name: 'Acne Prone Face Cleanser',
    price: 25.00,
    description: 'A gentle yet effective cleanser specifically formulated for acne-prone skin. This soap-free formula removes impurities while maintaining skin\'s natural balance.',
    ingredients: [
      'Salicylic Acid',
      'Tea Tree Oil',
      'Aloe Vera',
      'Niacinamide',
      'Green Tea Extract'
    ],
    image: cleanserImage,
    category: 'Cleanser'
  },
  {
    id: '2',
    name: 'Dark Spot Serum with Niacinamide',
    price: 23.99,
    description: 'Target stubborn dark spots and uneven skin tone with this powerful serum. Formulated with Niacinamide and natural brightening ingredients.',
    ingredients: [
      'Niacinamide',
      'Alpha Arbutin',
      'Vitamin C',
      'Licorice Root Extract',
      'Hyaluronic Acid'
    ],
    image: darkspotImage,
    category: 'Serum'
  },
  {
    id: '3',
    name: 'Vitamin C Moisturizer',
    price: 25.00,
    description: 'A brightening and hydrating moisturizer enriched with stable Vitamin C to protect and nourish your skin throughout the day.',
    ingredients: [
      'Vitamin C (L-Ascorbic Acid)',
      'Vitamin E',
      'Ferulic Acid',
      'Squalane',
      'Ceramides'
    ],
    image: moisturizerImage,
    category: 'Moisturizer'
  },
  {
    id: '4',
    name: 'Eye Serum with Retinol',
    price: 30.00,
    description: 'A gentle yet effective eye serum that targets fine lines, dark circles, and puffiness while you sleep.',
    ingredients: [
      'Retinol',
      'Peptides',
      'Caffeine',
      'Hyaluronic Acid',
      'Vitamin E'
    ],
    image: serumImage,
    category: 'Eye Care'
  },
  {
    id: '5',
    name: 'Hydrating Toner',
    price: 19.99,
    description: 'An alcohol-free, hydrating toner that balances skin\'s pH while providing essential moisture and preparing skin for the next steps in your routine.',
    ingredients: [
      'Rose Water',
      'Glycerin',
      'Panthenol',
      'Centella Asiatica',
      'Beta-Glucan'
    ],
    image: tonerImage,
    category: 'Toner'
  },
  {
    id: '6',
    name: 'Lip Mask',
    price: 13.99,
    description: 'Revitalize your lips overnight with our rich Lip Mask, enriched with natural oils and butters for deep hydration and repair.',
    ingredients: [
      'Shea Butter',
      'Coconut Oil',
      'Beeswax',
      'Jojoba Oil',
      'Vitamin E'
    ],
    image: maskImage,
    category: 'Lip Care'
  }
];