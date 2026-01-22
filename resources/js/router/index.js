import { createRouter, createWebHistory } from 'vue-router';

// Importar las páginas/vistas
import Home from '../pages/Home.vue';
import ProductList from '../pages/ProductList.vue';
import ProductDetail from '../pages/ProductDetail.vue';
import Cart from '../pages/Cart.vue';
import Checkout from '../pages/Checkout.vue';

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/productos',
    name: 'ProductList',
    component: ProductList
  },
  {
    path: '/producto/:id',
    name: 'ProductDetail',
    component: ProductDetail
  },
  {
    path: '/carrito',
    name: 'Cart',
    component: Cart
  },
  {
    path: '/checkout',
    name: 'Checkout',
    component: Checkout
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    // Si hay una posición guardada (navegación hacia atrás/adelante)
    if (savedPosition) {
      return savedPosition;
    }
    // Siempre volver al inicio en navegación nueva
    return { top: 0, behavior: 'smooth' };
  }
});

export default router;
