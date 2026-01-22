<template>
  <v-app>
    <!-- Navbar -->
    <v-app-bar
      ref="navbar"
      color="#740d11"
      elevation="0"
      height="auto"
      class="py-0 main-navbar"
    >
      <v-container class="d-flex align-center">
        <v-app-bar-title class="pa-0">
          <router-link to="/" class="brand-logo text-decoration-none">
              <img :src="logoTitulo" alt="Estilo Mafia Hats" class="logo-img">
          </router-link>
        </v-app-bar-title>

        <v-spacer></v-spacer>

        <div class="nav-links d-none d-md-flex align-center">
          <v-btn
            :to="{ name: 'Home' }"
            variant="text"
            class="nav-link"
            color="white"
          >
            Inicio
          </v-btn>
          <v-btn
            :to="{ name: 'ProductList' }"
            variant="text"
            class="nav-link"
            color="white"
          >
            Colección
          </v-btn>
          <v-btn
            :to="{ name: 'Cart' }"
            icon
            variant="text"
            color="white"
            size="large"
          >
            <v-badge
              v-if="itemCount > 0"
              :content="itemCount"
              color="white"
              text-color="black"
            >
              <v-icon>mdi-shopping</v-icon>
            </v-badge>
            <v-icon v-else>mdi-shopping-outline</v-icon>
          </v-btn>
        </div>

        <!-- Mobile Menu -->
        <v-app-bar-nav-icon
          class="d-md-none"
          color="white"
          @click="drawer = !drawer"
        ></v-app-bar-nav-icon>
      </v-container>
    </v-app-bar>

    <!-- Mobile Drawer -->
    <v-navigation-drawer
      v-model="drawer"
      temporary
      location="right"
      class="drawerapp"
    >
      <v-list>
        <v-list-item
          :to="{ name: 'Home' }"
          prepend-icon="mdi-home"
          title="Inicio"
        ></v-list-item>
        <v-list-item
          :to="{ name: 'ProductList' }"
          prepend-icon="mdi-shopping"
          title="Colección"
        ></v-list-item>
        <v-list-item
          :to="{ name: 'Cart' }"
          prepend-icon="mdi-cart"
        >
          <template v-slot:title>
            Carrito
            <v-chip v-if="itemCount > 0" size="small" class="ml-2">{{ itemCount }}</v-chip>
          </template>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <!-- Contenido principal -->
    <v-main>
      <router-view></router-view>
    </v-main>

    <!-- Botón flotante de WhatsApp -->
    <v-btn
      class="whatsapp-float"
      color="#25D366"
      size="x-large"
      icon
      elevation="8"
      href="https://wa.me/5214444901341?text=Hola,%20me%20interesan%20sus%20productos"
      target="_blank"
    >
      <v-icon size="32">mdi-whatsapp</v-icon>
    </v-btn>

    <!-- Footer -->
    <v-footer color="#740d11" class="footer">
      <v-container>
        <v-row class="py-8">
          <v-col cols="12" md="4" class="mb-6 mb-md-0">
            <div class="footer-brand mb-4">
           <img :src="logo" alt="Estilo Mafia Hats" class="logo-foter">
            </div>
            <p class="text-grey-lighten-1 footer-desc">
              Diseños con carácter para quienes no piden permiso para destacar.
            </p>
            <div class="social-links mt-4">
              <v-btn icon variant="text" color="white" size="mall" href="https://www.instagram.com/estilo_mafia_hats?igsh=ZGExZWY4YW1vczlj" target="_blank">
                <v-icon>mdi-instagram</v-icon>
              </v-btn>
              <!-- <v-btn icon variant="text" color="white" size="small">
                <v-icon>mdi-facebook</v-icon>
              </v-btn> -->
              <!-- <v-btn icon variant="text" color="white" size="small">
                <v-icon>mdi-twitter</v-icon>
              </v-btn> -->
            </div>
          </v-col>
          <v-col cols="12" md="4">
            <h4 class="footer-title mb-4">Tienda</h4>
            <div class="footer-links">
              <router-link to="/" class="footer-link">Inicio</router-link>
              <router-link :to="{ name: 'ProductList' }" class="footer-link">Colección</router-link>
              <router-link :to="{ name: 'Cart' }" class="footer-link">Carrito</router-link>
            </div>
          </v-col>
          <!-- <v-col cols="12" md="3">
            <h4 class="footer-title mb-4">Información</h4>
            <div class="footer-links">
              <a href="#" class="footer-link">Sobre Nosotros</a>
              <a href="#" class="footer-link">Envíos y Devoluciones</a>
              <a href="#" class="footer-link">Términos y Condiciones</a>
              <a href="#" class="footer-link">Política de Privacidad</a>
            </div>
          </v-col> -->
          <v-col cols="12" md="4">
            <h4 class="footer-title mb-4">Contacto</h4>
            <div class="footer-contact">
              <div class="contact-item">
                <v-icon size="small" color="white">mdi-whatsapp</v-icon>
                <span>+52 444 490 1341</span>
              </div>
              <div class="contact-item">
                <v-icon size="small" color="white">mdi-email</v-icon>
                <span>ing.josecharcas90@gmail.com</span>
              </div>
              <div class="contact-item">
                <v-icon size="small" color="white">mdi-map-marker</v-icon>
                <span>México</span>
              </div>
            </div>
          </v-col>
        </v-row>
        <v-divider class="border-opacity-25"></v-divider>
        <div class="text-center py-6">
          <p class="text-grey-lighten-1 text-body-2">
            © {{ new Date().getFullYear() }} Estilo Mafia Hats. Todos los derechos reservados.
          </p>
        </div>
      </v-container>
    </v-footer>
  </v-app>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { useCart } from './composables/useCart';

const { itemCount } = useCart();
const drawer = ref(false);
const navbar = ref(null);
let lastScrollTop = 0;
let ticking = false;
const scrollThreshold = 5;

// Logo URL
const logoTitulo = computed(() => {
  return window.location.origin + '/logotitulo.webp';
});
const logo = computed(() => {
  return window.location.origin + '/logo.webp';
});

// Scroll behavior with requestAnimationFrame for smooth performance
const handleScroll = () => {
  if (!navbar.value) return;

  const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
  const scrollDifference = Math.abs(scrollTop - lastScrollTop);

  // Only process if we've scrolled enough
  if (scrollDifference < scrollThreshold) {
    ticking = false;
    return;
  }

  // Don't hide navbar if drawer is open
  if (drawer.value) {
    navbar.value.$el.classList.remove('hidden');
    ticking = false;
    return;
  }

  // Hide/show navbar based on scroll direction
  if (scrollTop > lastScrollTop && scrollTop > 150) {
    // Scrolling down & past threshold -> hide navbar
    navbar.value.$el.classList.add('hidden');
  } else if (scrollTop < lastScrollTop || scrollTop <= 100) {
    // Scrolling up OR at top -> show navbar
    navbar.value.$el.classList.remove('hidden');
  }

  lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
  ticking = false;
};

const onScroll = () => {
  if (!ticking) {
    requestAnimationFrame(handleScroll);
    ticking = true;
  }
};

onMounted(() => {
  window.addEventListener('scroll', onScroll, { passive: true });
});

onUnmounted(() => {
  window.removeEventListener('scroll', onScroll);
});
</script>

<style>
/* Brand Logo */


@import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap');

/* Aplicar Montserrat a toda la aplicación */
.v-application,
.v-application * {
  font-family: "Montserrat", sans-serif !important;
}

html,
body,
* {
  font-family: "Montserrat", sans-serif;
  margin: 0;
  padding: 0;
  scroll-behavior: smooth;
}

header {
  font-family: "Montserrat", sans-serif;
  margin: 0;
  padding: 0;
  font-size: 16px;
  scroll-behavior: smooth;
}

/* WhatsApp Float Button */
.whatsapp-float {
  position: fixed !important;
  bottom: 20px;
  right: 20px;
  z-index: 1000;
  box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4) !important;
  transition: all 0.3s ease !important;
}

.whatsapp-float:hover {
  transform: scale(1.1);
  box-shadow: 0 6px 30px rgba(37, 211, 102, 0.6) !important;
}

@media (max-width: 600px) {
  .whatsapp-float {
    bottom: 80px;
    right: 16px;
  }
}

.brand-logo {
  display: flex;
  align-items: center;
  gap: 12px;
}

/* Navbar hide animation */
.main-navbar {
  transition: transform 0.3s ease-in-out !important;
  will-change: transform;
}

.main-navbar.hidden {
  transform: translateY(-100%) !important;
}

.logo-img {
  height: auto;
  width: 440px;

  object-fit: contain;
  display: block;
}
.logo-foter {
  height: auto;
  width: 200px;

  object-fit: contain;
  display: block;
}
.drawerapp {
  font-family: "Montserrat", sans-serif;
  padding-top: 70px;

}

@media (min-width: 600px) and (max-width: 959px) {
  .drawerapp {
    padding-top: 70px;
  }
}

@media (min-width: 960px) {
  .drawerapp {
    padding-top: 80px;
  }
}
@media (max-width: 600px) {

  .logo-img {
width: 100%;
  }
  .logo-foter {
width: 150px;
  }
}

.brand-icon {
  font-size: 32px;
  line-height: 1;
}

.brand-text {
  display: flex;
  flex-direction: column;
  line-height: 1;
}

.brand-name {
  color: white;
  font-size: 18px;
  font-weight: 900;
  letter-spacing: 2px;
}

.brand-subtitle {
  color: rgba(255, 255, 255, 0.7);
  font-size: 11px;
  font-weight: 600;
  letter-spacing: 3px;
}

.nav-link {
  font-weight: 600;
  letter-spacing: 0.5px;
  margin: 0 4px;
}

/* Footer */
.footer {
  color: white;
}

.footer-brand {
  display: flex;
  align-items: center;
  gap: 12px;
}

.brand-icon-footer {
  font-size: 40px;
}

.footer-brand-text {
  display: flex;
  flex-direction: column;
  line-height: 1.2;
}

.footer-brand-name {
  font-size: 20px;
  font-weight: 900;
  letter-spacing: 2px;
  color: white;
}

.footer-brand-subtitle {
  font-size: 12px;
  font-weight: 600;
  letter-spacing: 3px;
  color: rgba(255, 255, 255, 0.7);
}

.footer-desc {
  font-size: 14px;
  line-height: 1.6;
  max-width: 300px;
}

.footer-title {
  color: white;
  font-size: 16px;
  font-weight: 700;
  letter-spacing: 1px;
  text-transform: uppercase;
}

.footer-links {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.footer-link {
  color: rgba(255, 255, 255, 0.7);
  text-decoration: none;
  font-size: 14px;
  transition: color 0.3s ease;
}

.footer-link:hover {
  color: white;
}

.footer-contact {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.contact-item {
  display: flex;
  align-items: center;
  gap: 12px;
  color: rgba(255, 255, 255, 0.7);
  font-size: 14px;
}

.social-links {
  display: flex;
  gap: 8px;
}
</style>
