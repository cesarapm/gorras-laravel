<template>
  <div class="hero-home">
    <!-- Hero Section -->
    <v-container fluid class="hero-section pa-0">
      <v-row no-gutters align="center" justify="center" class="fill-height">
        <v-col cols="12" md="10" lg="8" class="text-center py-12 py-md-16 px-4 px-md-6">
          <div class="hero-badge mb-4 mb-md-6">
            <span>ESTILO MAFIA HATS</span>
          </div>
          <h1 class="hero-title mb-4 mb-md-6">
            No Sigues Tendencias, <br> <br class="d-block d-md-none">

            <span class="accent-text">Las Representas</span>
          </h1>
          <p class="hero-subtitle mb-6 mb-md-10">
            Diseños con carácter. Producción cuidada. Detalles que marcan diferencia.<br class="d-none d-md-block">
            No somos lujo, somos <strong>exclusividad real</strong>.
          </p>
          <v-btn
            color="#740d11"
            :size="$vuetify.display.mobile ? 'large' : 'x-large'"
            class="px-8 px-md-12 py-2"
            elevation="8"
            @click="scrollToProducts"
          >
            Descubrir Colección
            <v-icon end :size="$vuetify.display.mobile ? 'default' : 'large'">mdi-arrow-down</v-icon>
          </v-btn>
        </v-col>
      </v-row>
    </v-container>

    <!-- Brand Philosophy -->
    <v-container class="philosophy-section my-8 my-md-16">
      <v-row align="center">
        <v-col cols="12" md="6" class="px-4 px-md-8 mb-6 mb-md-0">
          <div class="section-tag mb-3 mb-md-4">NUESTRA FILOSOFÍA</div>
          <h2 class="text-h4 text-md-h3 font-weight-black mb-4 mb-md-6">
            Piezas Pensadas Para Destacar Sin Pedir Permiso
          </h2>
          <p class="text-body-1 text-md-h6 text-grey-darken-1 line-height-relaxed">
            Estilo Mafia Hats es una marca creada para quienes entienden que el estilo también es una declaración.
            Cada gorra es producida con atención meticulosa a los detalles, materiales seleccionados y diseños
            que no necesitan gritar para ser escuchados.
          </p>
        </v-col>
        <v-col cols="12" md="6">
          <v-row>
            <v-col cols="6" class="text-center pa-4 pa-md-8">
              <div class="stat-box">
                <div class="stat-number">100%</div>
                <div class="stat-label">Exclusivo</div>
              </div>
            </v-col>
            <v-col cols="6" class="text-center pa-4 pa-md-8">
              <div class="stat-box">
                <div class="stat-number">Premium</div>
                <div class="stat-label">Calidad</div>
              </div>
            </v-col>
            <v-col cols="6" class="text-center pa-4 pa-md-8">
              <div class="stat-box">
                <div class="stat-number">Único</div>
                <div class="stat-label">Diseño</div>
              </div>
            </v-col>
            <v-col cols="6" class="text-center pa-4 pa-md-8">
              <div class="stat-box">
                <div class="stat-number">Real</div>
                <div class="stat-label">Estilo</div>
              </div>
            </v-col>
          </v-row>
        </v-col>
      </v-row>
    </v-container>

    <!-- Características Premium -->
    <v-container fluid class="features-section py-8 py-md-16">
      <v-container>
        <v-row>
          <v-col cols="12" md="4" class="mb-4 mb-md-0">
            <div class="feature-card text-center pa-6 pa-md-8">
              <v-icon :size="$vuetify.display.mobile ? 40 : 56" class="mb-4 mb-md-6">mdi-shield-check</v-icon>
              <h3 class="text-h6 text-md-h5 font-weight-bold mb-3 mb-md-4">Calidad Garantizada</h3>
              <p class="text-body-2 text-md-body-1 text-grey-darken-1">
                Materiales premium seleccionados. Cada pieza pasa por control de calidad riguroso.
              </p>
            </div>
          </v-col>
          <v-col cols="12" md="4" class="mb-4 mb-md-0">
            <div class="feature-card text-center pa-6 pa-md-8">
              <v-icon :size="$vuetify.display.mobile ? 40 : 56" class="mb-4 mb-md-6">mdi-palette</v-icon>
              <h3 class="text-h6 text-md-h5 font-weight-bold mb-3 mb-md-4">Diseño Exclusivo</h3>
              <p class="text-body-2 text-md-body-1 text-grey-darken-1">
                Ediciones limitadas pensadas para destacar. No encontrarás dos iguales.
              </p>
            </div>
          </v-col>
          <v-col cols="12" md="4">
            <div class="feature-card text-center pa-6 pa-md-8">
              <v-icon :size="$vuetify.display.mobile ? 40 : 56" class="mb-4 mb-md-6">mdi-truck-fast</v-icon>
              <h3 class="text-h6 text-md-h5 font-weight-bold mb-3 mb-md-4">Envío Rápido</h3>
              <p class="text-body-2 text-md-body-1 text-grey-darken-1">
                Envíos express a toda la república. Tu estilo no puede esperar.
              </p>
            </div>
          </v-col>
        </v-row>
      </v-container>
    </v-container>

    <!-- Productos Destacados -->
    <v-container id="productos" class="my-8 my-md-16">
      <div class="text-center mb-8 mb-md-12 px-4">
        <div class="section-tag mb-3 mb-md-4">COLECCIÓN</div>
        <h2 class="text-h3 text-md-h2 font-weight-black mb-3 mb-md-4">Piezas Destacadas</h2>
        <p class="text-body-1 text-md-h6 text-grey-darken-1">Diseños que no piden permiso para destacar</p>
      </div>

      <v-row v-if="loading" justify="center">
        <v-col cols="12" class="text-center py-12">
          <v-progress-circular indeterminate color="grey-darken-4" size="64"></v-progress-circular>
          <p class="text-h6 mt-4 text-grey">Cargando colección...</p>
        </v-col>
      </v-row>

      <v-row v-if="!loading">
        <v-col
          v-for="product in featuredProducts"
          :key="product.id"
          cols="12" sm="6" md="4" lg="3"
        >
          <v-card
            hover
            class="product-card"
            elevation="2"
            @click="viewProduct(product.id)"
          >
            <div class="product-badge">EXCLUSIVO</div>
            <div class="product-image-container">
              <v-img
                v-if="product.image"
                :src="product.image"
                :alt="product.name"
                container
                height="280"
                class="product-image"
              />
              <div v-else class="product-placeholder">
                <span class="product-emoji">{{ getProductEmoji(product.category) }}</span>
              </div>
            </div>
            <v-card-text class="px-4 px-md-6 pt-4 pt-md-6">
              <div class="product-category text-caption text-grey-darken-1 mb-2 text-uppercase">
                {{ product.category || 'Premium' }}
              </div>
              <h3 class="text-subtitle-1 text-md-h6 font-weight-bold mb-2 mb-md-3">{{ product.name }}</h3>
              <p class="text-caption text-md-body-2 text-grey-darken-1 line-clamp-2">{{ product.description }}</p>
            </v-card-text>
            <v-card-actions class="px-4 px-md-6 pb-4 pb-md-6 pt-0">
              <div class="price-tag">
                <span class="price-amount">${{ product.price }}</span>
                <span class="price-label">MXN</span>
              </div>
              <!-- <v-spacer></v-spacer>
              <v-btn
                color="#740d11"
                variant="flat"
                :size="$vuetify.display.mobile ? 'default' : 'large'"
                @click.stop="addToCart(product)"
              >
                <v-icon :start="!$vuetify.display.mobile">mdi-cart-plus</v-icon>
                <span v-if="!$vuetify.display.mobile">Agregar</span>
              </v-btn> -->
            </v-card-actions>
                        <v-card-actions class="px-4 px-md-6 pb-4 pb-md-6 pt-0">
              <!-- <div class="price-tag">
                <span class="price-amount">${{ product.price }}</span>
                <span class="price-label">MXN</span>
              </div>
              <v-spacer></v-spacer> -->
              <v-btn
                color="#740d11"
                variant="flat"
                class="pa-3"
                :size="$vuetify.display.mobile ? 'default' : 'large'"
                @click.stop="addToCart(product)"
              >
                <v-icon :start="!$vuetify.display.mobile">mdi-cart-plus</v-icon>
                <span v-if="!$vuetify.display.mobile">Agregar</span>
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>

      <div class="text-center mt-8 mt-md-12">
        <v-btn
          color="grey-darken-4"
          :size="$vuetify.display.mobile ? 'large' : 'x-large'"
          variant="outlined"
          :class="$vuetify.display.mobile ? 'px-8' : 'px-12'"
          :to="{ name: 'ProductList' }"
        >
          Ver Toda la Colección
          <v-icon end>mdi-arrow-right</v-icon>
        </v-btn>
      </div>
    </v-container>


    <!-- Snackbar -->
    <v-snackbar v-model="snackbar" :timeout="2000" color="#740d11">
      <v-icon start>mdi-check-circle</v-icon>
      {{ snackbarText }}
    </v-snackbar>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useCart } from '../composables/useCart';

const router = useRouter();
const featuredProducts = ref([]);
const loading = ref(false);

const categoryEmojis = {
  'clasica': '🎩',
  'deportiva': '⚡',
  'vintage': '🎨',
  'urbana': '🔥',
  'premium': '👑'
};

const fetchFeaturedProducts = async () => {
  loading.value = true;
  try {
    const response = await fetch('/api/products/featured');
    featuredProducts.value = await response.json();
  } catch (error) {
    console.error('Error al cargar productos destacados:', error);
  } finally {
    loading.value = false;
  }
};

onMounted(() => {
  fetchFeaturedProducts();
});

const getProductEmoji = (category) => {
  return categoryEmojis[category] || '🧢';
};

const { addToCart: addProductToCart } = useCart();

const snackbar = ref(false);
const snackbarText = ref('');

const addToCart = (product) => {
  addProductToCart(product, 1);
  snackbarText.value = `${product.name} agregado al carrito`;
  snackbar.value = true;
};

const viewProduct = (id) => {
  router.push({ name: 'ProductDetail', params: { id } });
};

const scrollToProducts = () => {
  document.getElementById('productos').scrollIntoView({ behavior: 'smooth' });
};
</script>

<style scoped>
/* Contenedor principal */
.hero-home {
  overflow-x: hidden;
  width: 100%;
  max-width: 100vw;
}

/* Hero Section */
.hero-section {
  background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
  color: white;
  min-height: 500px;
  position: relative;
  overflow: hidden;
  margin-top: 80px;
}

@media (min-width: 960px) {
  .hero-section {
    min-height: 700px;
  }
}

.hero-section::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-image:
    repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(255,255,255,.02) 10px, rgba(255,255,255,.02) 20px);
}

.hero-badge {
  display: inline-block;
  padding: 6px 16px;
  background: rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 50px;
  font-size: 10px;
  letter-spacing: 2px;
  font-weight: 600;
}

@media (min-width: 960px) {
  .hero-badge {
    padding: 8px 24px;
    font-size: 12px;
    letter-spacing: 3px;
  }
}

.hero-title {
  font-size: clamp(1.75rem, 5vw, 4.3rem);
  font-weight: 900;
  line-height: 1.2;
  letter-spacing: -1px;
}

@media (min-width: 960px) {
  .hero-title {
    line-height: 1.1;
    letter-spacing: -2px;

  }
}

.accent-text {
  background: linear-gradient(135deg, #ffffff 0%, #a0a0a0 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  font-size: 60px;
  margin-top: 0px !important;

}

.hero-subtitle {
  font-size: clamp(0.875rem, 2vw, 1.25rem);
  color: rgba(255, 255, 255, 0.8);
  max-width: 700px;
  margin-left: auto;
  margin-right: auto;
  line-height: 1.6;
}

@media (min-width: 960px) {
  .hero-subtitle {
    line-height: 1.8;
  }
}

/* Philosophy Section */
.philosophy-section {
  background: #fafafa;
  padding: 40px 0;
}

@media (min-width: 960px) {
  .philosophy-section {
    padding: 80px 20px;
  }
}

.section-tag {
  font-size: 11px;
  letter-spacing: 3px;
  font-weight: 700;
  color: #666;
  text-transform: uppercase;
}

.line-height-relaxed {
  line-height: 1.8;
}

.stat-box {
  background: white;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.05);
  transition: transform 0.3s ease;
}

@media (min-width: 960px) {
  .stat-box {
    padding: 32px;
    border-radius: 16px;
  }
}

.stat-box:hover {
  transform: translateY(-8px);
}

.stat-number {
  font-size: 1.75rem;
  font-weight: 900;
  color: #1a1a1a;
  margin-bottom: 8px;
}

@media (min-width: 960px) {
  .stat-number {
    font-size: 2.5rem;
  }
}

.stat-label {
  font-size: 0.875rem;
  text-transform: uppercase;
  letter-spacing: 2px;
  color: #666;
}

/* Features Section */
.features-section {
  background: #f5f5f5;
}

.feature-card {
  background: white;
  border-radius: 16px;
  height: 100%;
  transition: all 0.3s ease;
}

.feature-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 40px rgba(0,0,0,0.1);
}

.feature-card .v-icon {
  color: #1a1a1a;
}

/* Product Cards */
.product-card {
  border-radius: 16px !important;
  overflow: hidden;
  transition: all 0.3s ease;
  cursor: pointer;
  position: relative;
  height: 100%;
}

.product-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 20px 50px rgba(0,0,0,0.15) !important;
}

.product-badge {
  position: absolute;
  top: 16px;
  right: 16px;
  background: #740d11;
  color: white;
  padding: 6px 16px;
  border-radius: 20px;
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 1.5px;
  z-index: 2;
}

.product-image-container {
  position: relative;
  overflow: hidden;
  background: #f8f8f8;
}

.product-image {
  transition: transform 0.5s ease;
}

.product-card:hover .product-image {
  transform: scale(1.05);
}

.product-placeholder {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 280px;
  background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
}

.product-emoji {
  font-size: 100px;
}

.product-category {
  font-weight: 600;
  letter-spacing: 1.5px;
}

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.price-tag {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}

.price-amount {
  font-size: 1.5rem;
  font-weight: 900;
  color: #1a1a1a;
  line-height: 1;
}

@media (min-width: 960px) {
  .price-amount {
    font-size: 1.75rem;
  }
}

.price-label {
  font-size: 0.75rem;
  color: #666;
  font-weight: 600;
  letter-spacing: 1px;
}

/* Responsive */
@media (max-width: 960px) {
  .hero-section {
    min-height: 500px;
    margin-top: 80px;
    padding: 30px;


  }

  .philosophy-section {
    padding: 60px 20px;
  }
  .accent-text {
  background: linear-gradient(135deg, #ffffff 0%, #a0a0a0 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  font-size: 30px;
}
}
</style>
