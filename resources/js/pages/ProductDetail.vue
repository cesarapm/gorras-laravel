<template>
  <v-container class="my-8 detalle-producto">
    <v-btn
      variant="text"
      @click="$router.back()"
      class="mb-4"
    >
      <v-icon start>mdi-arrow-left</v-icon>
      Volver
    </v-btn>

    <v-row v-if="loading">
      <v-col cols="12" class="text-center py-12">
        <v-progress-circular indeterminate color="primary" size="64"></v-progress-circular>
        <p class="text-h6 mt-4">Cargando producto...</p>
      </v-col>
    </v-row>

    <v-row v-if="!loading && product">
      <v-col cols="12" md="6">
        <v-card class="product-image d-flex align-center justify-center pa-16">
          <v-img
            v-if="product.image"
            :src="product.image"
            :alt="product.name"
            max-height="400"
            contain
          />
          <span v-else style="font-size: 200px;">{{ getProductEmoji(product.category) }}</span>
        </v-card>
      </v-col>

      <v-col cols="12" md="6">
        <h1 class="text-h3 mb-4">{{ product.name }}</h1>
        <p class="text-h4 font-weight-bold text-primary mb-4">${{ product.price }}</p>

        <v-chip
          class="mb-4"
          :color="product.stock > 0 ? 'success' : 'error'"
        >
          {{ product.stock > 0 ? `${product.stock} en stock` : 'Agotado' }}
        </v-chip>

        <v-divider class="my-4"></v-divider>

        <p class="text-body-1 mb-6">{{ product.description }}</p>

        <v-card class="mb-6 pa-4" variant="outlined">
          <h3 class="mb-3">Características:</h3>
          <v-list density="compact">
            <v-list-item prepend-icon="mdi-check-circle">100% Algodón</v-list-item>
            <v-list-item prepend-icon="mdi-check-circle">Ajustable</v-list-item>
            <v-list-item prepend-icon="mdi-check-circle">Lavable a máquina</v-list-item>
            <v-list-item prepend-icon="mdi-check-circle">Talla única</v-list-item>
          </v-list>
        </v-card>

        <v-row>
          <v-col cols="12" sm="6">
            <v-text-field
              v-model="quantity"
              type="number"
              label="Cantidad"
              variant="outlined"
              min="1"
            ></v-text-field>
          </v-col>
        </v-row>

        <v-btn
          color="primary"
          size="large"
          block
          class="mb-3"
          @click="addToCart"
          :disabled="!product || product.stock === 0"
        >
          <v-icon start>mdi-cart</v-icon>
          {{ product && product.stock > 0 ? 'Agregar al Carrito' : 'No Disponible' }}
        </v-btn>

        <v-btn
          color="grey-darken-4"
          size="large"
          block
          variant="outlined"
          @click="buyNow"
          :disabled="!product || product.stock === 0"
        >
          Comprar Ahora
        </v-btn>
      </v-col>
    </v-row>

    <v-row v-if="!loading && !product" class="my-12">
      <v-col cols="12" class="text-center">
        <v-icon size="64" color="grey">mdi-alert-circle</v-icon>
        <p class="text-h5 mt-4">Producto no encontrado</p>
      </v-col>
    </v-row>

    <!-- Snackbar -->
    <v-snackbar v-model="snackbar" :timeout="2000" color="success">
      <v-icon start>mdi-check-circle</v-icon>
      {{ snackbarText }}
    </v-snackbar>
  </v-container>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useCart } from '../composables/useCart';

const route = useRoute();
const router = useRouter();
const quantity = ref(1);
const product = ref(null);
const loading = ref(false);

const categoryEmojis = {
  'clasica': '🎩',
  'deportiva': '⚡',
  'vintage': '🎨'
};

const fetchProduct = async () => {
  loading.value = true;
  try {
    const response = await fetch(`/api/products/${route.params.id}`);
    if (response.ok) {
      product.value = await response.json();
    } else {
      product.value = null;
    }
  } catch (error) {
    console.error('Error al cargar el producto:', error);
    product.value = null;
  } finally {
    loading.value = false;
  }
};

onMounted(() => {
  fetchProduct();
});

const getProductEmoji = (category) => {
  return categoryEmojis[category] || '🧢';
};

const { addToCart: addProductToCart } = useCart();

const snackbar = ref(false);
const snackbarText = ref('');

const addToCart = () => {
  if (product.value) {
    addProductToCart(product.value, quantity.value);
    snackbarText.value = `${quantity.value} x ${product.value.name} agregado al carrito`;
    snackbar.value = true;




}
}

const buyNow = () => {
  if (product.value) {
    addProductToCart(product.value, quantity.value);
    router.push({ name: 'Checkout' });
  }
};


</script>

<style scoped>


 .detalle-producto{
margin-top: 150px !important;
}
.product-image {

  min-height: 400px;
}
@media (max-width: 600px) {
 .detalle-producto{
margin-top: 80px !important;
}
}
</style>
