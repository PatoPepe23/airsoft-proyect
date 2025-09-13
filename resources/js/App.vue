<template>
    <div>
        <!-- Muestra el contenido solo si la carga ha finalizado -->
        <div v-if="!isLoading">
            <router-view></router-view>
            <CookieConsent />
        </div>
        <!-- Opcional: Puedes agregar un spinner de carga aquí -->
        <div v-else class="loading-container">
            Cargando...
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import useAuth from './composables/auth.js'; // Ajusta la ruta si es necesario

// Importación del componente existente
import CookieConsent from './components/CookieConsent.vue';

// Estado para manejar la carga de la autenticación
const isLoading = ref(true);

const { initSession } = useAuth();

onMounted(async () => {
    // Inicia la sesión de forma asíncrona
    await initSession();

    // Una vez que la sesión se ha inicializado, la carga ha terminado
    isLoading.value = false;
});
</script>

<style>
/* Estilos básicos para el mensaje de carga */
.loading-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    font-size: 1.5rem;
    color: #333;
}
</style>
