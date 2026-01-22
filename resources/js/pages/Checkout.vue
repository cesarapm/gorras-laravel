<template>
  <v-container class=" checked-page">
    <h1 class="text-h3 mb-8">Finalizar Compra</h1>

    <v-alert v-if="cartItems.length === 0" type="warning" class="mb-6">
      Tu carrito está vacío. <router-link :to="{ name: 'ProductList' }">Ver productos</router-link>
    </v-alert>

    <v-form v-else @submit.prevent="sendWhatsAppOrder">
      <v-row>
        <v-col cols="12" md="8">
          <!-- Información Personal -->
          <v-card class="mb-6">
            <v-card-title>📋 Información Personal</v-card-title>
            <v-card-text>
              <v-row>
                <v-col cols="12" sm="6">
                  <v-text-field
                    v-model="form.firstName"
                    label="Nombre *"
                    variant="outlined"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6">
                  <v-text-field
                    v-model="form.lastName"
                    label="Apellido *"
                    variant="outlined"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6">
                  <v-text-field
                    v-model="form.email"
                    label="Email *"
                    type="email"
                    variant="outlined"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6">
                  <v-text-field
                    v-model="form.phone"
                    label="Teléfono *"
                    variant="outlined"
                    required
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>

          <!-- Dirección de Envío -->
          <v-card class="mb-6">
            <v-card-title>📍 Dirección de Envío</v-card-title>
            <v-card-text>
              <v-row>
                <v-col cols="12">
                  <v-text-field
                    v-model="form.address"
                    label="Dirección *"
                    variant="outlined"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="4">
                  <v-text-field
                    v-model="form.city"
                    label="Ciudad *"
                    variant="outlined"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="4">
                  <v-text-field
                    v-model="form.state"
                    label="Estado *"
                    variant="outlined"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="4">
                  <v-text-field
                    v-model="form.zipCode"
                    label="Código Postal *"
                    variant="outlined"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-textarea
                    v-model="form.notes"
                    label="Notas adicionales (opcional)"
                    variant="outlined"
                    rows="2"
                  ></v-textarea>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>

          <!-- Método de Pago -->
          <v-card>
            <v-card-title>💳 Método de Pago</v-card-title>
            <v-card-text>
              <v-radio-group v-model="form.paymentMethod">
                <v-radio
                  label="💵 Pago contra entrega (efectivo)"
                  value="cash"
                ></v-radio>
                <v-radio
                  label="💳 Transferencia bancaria"
                  value="transfer"
                ></v-radio>
                <v-radio
                  label="📱 Pago móvil"
                  value="mobile"
                ></v-radio>
              </v-radio-group>
            </v-card-text>
          </v-card>
        </v-col>

        <!-- Resumen -->
        <v-col cols="12" md="4">
          <v-card class="mb-4">
            <v-card-title>🛒 Tu Pedido</v-card-title>
            <v-divider></v-divider>
            <v-list density="compact">
              <v-list-item v-for="item in cartItems" :key="item.id">
                <v-list-item-title>
                  {{ item.name }} x{{ item.quantity }}
                </v-list-item-title>
                <template v-slot:append>
                  <span>${{ (item.price * item.quantity).toFixed(2) }}</span>
                </template>
              </v-list-item>
            </v-list>
          </v-card>

          <v-card>
            <v-card-title>💰 Resumen</v-card-title>
            <v-divider></v-divider>
            <v-card-text>
              <div class="d-flex justify-space-between mb-2">
                <span>Subtotal:</span>
                <span>${{ subtotal.toFixed(2) }}</span>
              </div>
              <div class="d-flex justify-space-between mb-2">
                <span>Envío:</span>
                <span>${{ shippingCost.toFixed(2) }}</span>
              </div>
              <v-divider class="my-3"></v-divider>
              <div class="d-flex justify-space-between">
                <span class="font-weight-bold text-h6">Total:</span>
                <span class="font-weight-bold text-h5 text-success">
                  ${{ total.toFixed(2) }}
                </span>
              </div>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions class="flex-column pa-4">
              <v-btn
                color="success"
                block
                size="large"
                type="submit"
                prepend-icon="mdi-whatsapp"
                class="mb-2"
              >
                Enviar Pedido por WhatsApp
              </v-btn>
              <v-btn
                variant="outlined"
                block
                @click="$router.back()"
              >
                Volver
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
    </v-form>

    <!-- Modal de Éxito -->
    <v-dialog v-model="successDialog" max-width="500" persistent>
      <v-card>
        <v-card-title class="text-h5 text-center py-6 bg-success">
          <v-icon size="64" color="white" class="mb-2">mdi-check-circle</v-icon>
          <div class="text-white">¡Pedido Creado!</div>
        </v-card-title>
        <v-card-text class="text-center pa-6">
          <p class="text-h6 mb-2">Orden #{{ orderNumber }}</p>
          <p class="text-body-1 mb-4">Total: ${{ orderTotal }}</p>
          <p class="text-body-2 text-grey mb-4">Haz click en el botón para enviar tu pedido por WhatsApp</p>
        </v-card-text>
        <v-card-actions class="justify-center pb-6 flex-column">
          <v-btn
            color="success"
            size="large"
            block
            prepend-icon="mdi-whatsapp"
            @click="openWhatsApp"
            class="mb-3"
          >
            Abrir WhatsApp
          </v-btn>
          <v-btn
            variant="outlined"
            @click="closeSuccessDialog"
            block
          >
            Cerrar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- Modal de Error -->
    <v-dialog v-model="errorDialog" max-width="500">
      <v-card>
        <v-card-title class="text-h5 text-center py-6 bg-error">
          <v-icon size="64" color="white" class="mb-2">mdi-alert-circle</v-icon>
          <div class="text-white">Error</div>
        </v-card-title>
        <v-card-text class="text-center pa-6">
          <p class="text-body-1">{{ errorMessage }}</p>
        </v-card-text>
        <v-card-actions class="justify-center pb-6">
          <v-btn color="error" @click="errorDialog = false">Cerrar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- Snackbar de validación -->
    <v-snackbar v-model="validationSnackbar" color="warning" :timeout="3000">
      Por favor completa todos los campos requeridos
    </v-snackbar>
  </v-container>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useRouter } from 'vue-router';
import { useCart } from '../composables/useCart';

const router = useRouter();
const { cartItems, subtotal, total: cartTotal, clearCart } = useCart();

// Configura tu número de WhatsApp aquí (con código de país, sin +)
const WHATSAPP_NUMBER = '5214444901341'; // Ejemplo: Argentina

const form = ref({
  firstName: '',
  lastName: '',
  email: '',
  phone: '',
  address: '',
  city: '',
  state: '',
  zipCode: '',
  notes: '',
  paymentMethod: 'cash'
});

const shippingCost = computed(() => subtotal.value > 50 ? 0 : 10);
const total = computed(() => subtotal.value + shippingCost.value);

// Estados para modales
const successDialog = ref(false);
const errorDialog = ref(false);
const validationSnackbar = ref(false);
const errorMessage = ref('');
const orderNumber = ref('');
const orderTotal = ref(0);
const whatsappUrl = ref('');

const openWhatsApp = () => {
  window.open(whatsappUrl.value, '_blank');
};

const closeSuccessDialog = () => {
  successDialog.value = false;
  clearCart();
  router.push({ name: 'Home' });
};

const sendWhatsAppOrder = async () => {
  // Validar formulario
  if (!form.value.firstName || !form.value.lastName || !form.value.phone || !form.value.address) {
    validationSnackbar.value = true;
    return;
  }

  try {
    // 1. Guardar orden en la base de datos
    const orderData = {
      customer_first_name: form.value.firstName,
      customer_last_name: form.value.lastName,
      customer_email: form.value.email,
      customer_phone: form.value.phone,
      shipping_address: form.value.address,
      shipping_city: form.value.city,
      shipping_state: form.value.state,
      shipping_zip_code: form.value.zipCode,
      subtotal: subtotal.value,
      shipping_cost: shippingCost.value,
      total: total.value,
      payment_method: form.value.paymentMethod,
      notes: form.value.notes,
      items: cartItems.value.map(item => ({
        product_id: item.id,
        product_name: item.name,
        quantity: item.quantity,
        unit_price: item.price,
        total: item.price * item.quantity
      }))
    };

    const response = await fetch('/api/orders', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify(orderData)
    });

    const result = await response.json();

    if (!response.ok || !result.success) {
      throw new Error(result.message || 'Error al crear la orden');
    }

    // 2. Crear mensaje de WhatsApp
    let message = `🛍️ *NUEVO PEDIDO #${result.order.order_number}*\n\n`;
    message += `👤 *Cliente:* ${form.value.firstName} ${form.value.lastName}\n`;
    message += `📧 *Email:* ${form.value.email}\n`;
    message += `📱 *Teléfono:* ${form.value.phone}\n\n`;

    message += `📍 *Dirección de Envío:*\n`;
    message += `${form.value.address}\n`;
    message += `${form.value.city}, ${form.value.state} ${form.value.zipCode}\n\n`;

    message += `🛒 *Productos:*\n`;
    cartItems.value.forEach(item => {
      message += `• ${item.name} x${item.quantity} - $${(item.price * item.quantity).toFixed(2)}\n`;
    });

    message += `\n💰 *Resumen:*\n`;
    message += `Subtotal: $${subtotal.value.toFixed(2)}\n`;
    message += `Envío: $${shippingCost.value.toFixed(2)}\n`;
    message += `*TOTAL: $${total.value.toFixed(2)}*\n\n`;

    const paymentMethods = {
      cash: '💵 Pago contra entrega',
      transfer: '💳 Transferencia bancaria',
      mobile: '📱 Pago móvil'
    };
    message += `💳 *Método de pago:* ${paymentMethods[form.value.paymentMethod]}\n`;

    if (form.value.notes) {
      message += `\n📝 *Notas:* ${form.value.notes}`;
    }

    // 3. Codificar mensaje para URL
    const encodedMessage = encodeURIComponent(message);

    // 4. Guardar URL de WhatsApp
    const whatsappLink = `https://wa.me/${WHATSAPP_NUMBER}?text=${encodedMessage}`;
    whatsappUrl.value = whatsappLink;
    // console.log('URL de WhatsApp generada:', whatsappLink);

    // 5. Mostrar modal de éxito
    orderNumber.value = result.order.order_number;
    orderTotal.value = total.value.toFixed(2);
    successDialog.value = true;

  } catch (error) {
    console.error('Error al procesar la orden:', error);
    errorMessage.value = 'Error al procesar tu pedido: ' + error.message;
    errorDialog.value = true;
  }
};
</script>
<style>
    header{
    font-family: "Montserrat", sans-serif;
    margin: 0;
    padding: 0;
    font-size: 16px;
    scroll-behavior: smooth;
}
* {
      font-family:"Montserrat", sans-serif;
    margin: 0;
    padding: 0;
    font-size: 16px;
    scroll-behavior: smooth;
  }
.checked-page{
margin-top: 150px !important;
}


</style>
