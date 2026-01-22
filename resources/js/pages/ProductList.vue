<template>
  <v-container class="my-8 product-list">
    <h1 class="text-h3 mb-8">Todos los Productos</h1>

    <!-- Filtros -->
    <v-row class="mb-6">
      <v-col cols="12" md="4">
        <v-select
          v-model="selectedCategory"
          :items="categories"
          label="Categoría"
          variant="outlined"
        ></v-select>
      </v-col>
      <v-col cols="12" md="4">
        <v-select
          v-model="sortBy"
          :items="sortOptions"
          label="Ordenar por"
          variant="outlined"
        ></v-select>
      </v-col>
      <v-col cols="12" md="4">
        <v-text-field
          v-model="search"
          label="Buscar"
          prepend-inner-icon="mdi-magnify"
          variant="outlined"
          clearable
        ></v-text-field>
      </v-col>
    </v-row>

    <!-- Grid de productos -->
    <v-row v-if="!loading">
      <v-col
        v-for="product in filteredProducts"
        :key="product.id"
        cols="12" sm="6" md="4" lg="3"
      >
        <v-card hover @click="viewProduct(product.id)">
          <div class="product-image d-flex align-center justify-center pa-8">
            <v-img
              v-if="product.image"
              :src="product.image"
              :alt="product.name"
              contain
              height="200"
            />
            <span v-else style="font-size: 64px;">{{ getProductEmoji(product.category) }}</span>
          </div>
          <v-card-text>
            <h3 class="text-h6 mb-2">{{ product.name }}</h3>
            <p class="text-grey text-body-2">{{ product.description }}</p>
          </v-card-text>
          <v-card-actions class="px-4 pb-4">
            <span class="text-h6 font-weight-bold">${{ product.price }}</span>
            <v-spacer></v-spacer>
            <v-btn
              color="primary"
              size="small"
              @click.stop="addToCart(product)"
              :disabled="product.stock === 0"
            >
              {{ product.stock === 0 ? 'Agotado' : 'Agregar' }}
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>

    <v-row v-if="loading">
      <v-col cols="12" class="text-center py-12">
        <v-progress-circular indeterminate color="primary" size="64"></v-progress-circular>
        <p class="text-h6 mt-4">Cargando productos...</p>
      </v-col>
    </v-row>

    <v-row v-if="filteredProducts.length === 0">
      <v-col cols="12" class="text-center py-12">
        <v-icon size="64" color="grey">mdi-package-variant</v-icon>
        <p class="text-h6 text-grey mt-4">No se encontraron productos</p>
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
import { ref, computed, onMounted, watch } from 'vue';
import { useRouter } from 'vue-router';
import { useCart } from '../composables/useCart';

const router = useRouter();

const selectedCategory = ref('Todas');
const sortBy = ref('name');
const search = ref('');
const products = ref([]);
const loading = ref(false);

const categories = [
  'Todas',
  'clasica',
  'deportiva',
  'vintage'
];

const sortOptions = [
  { title: 'Nombre', value: 'name' },
  { title: 'Precio: Menor a Mayor', value: 'price-asc' },
  { title: 'Precio: Mayor a Menor', value: 'price-desc' }
];

const categoryEmojis = {
  'clasica': '🎩',
  'deportiva': '⚡',
  'vintage': '🎨'
};

const fetchProducts = async () => {
  loading.value = true;
  try {
    const params = new URLSearchParams();

    if (selectedCategory.value && selectedCategory.value !== 'Todas') {
      params.append('category', selectedCategory.value);
    }

    if (search.value) {
      params.append('search', search.value);
    }

    if (sortBy.value) {
      params.append('sort', sortBy.value);
    }


    const response = await fetch(`/api/products?${params}`);

    // console.log('API Response:', response);
    products.value = await response.json();


  } catch (error) {
    console.error('Error al cargar productos:', error);
  } finally {
    loading.value = false;
  }
};

onMounted(() => {
  fetchProducts();
});

watch([selectedCategory, sortBy, search], () => {
  fetchProducts();
});

const filteredProducts = computed(() => products.value);

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

const getProductEmoji = (category) => {
  return categoryEmojis[category] || '🧢';
};
</script>

<style scoped>
.product-image {

  min-height: 150px;
}
.product-list{
margin-top: 150px !important;
}
.product-list .v-card {
  cursor: pointer;
  transition: box-shadow 0.3s ease;
}
.product-list .v-card:hover {
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}
@media (max-width: 600px) {
    .product-list{
margin-top: 80px !important;
    }
}
</style>
