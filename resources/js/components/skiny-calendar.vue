<template>
    <div class="skiny-calendar-container">
        <div class="row row-cols-2 skiny-calendar-div justify-content-center">
            <!-- Tarjetas de partidas -->
            <div v-for="partida in visibleGames" :key="partida.id" class="col2 game-card">
                <!-- Plazas con color dinámico -->
                <p class="plazas" :class="getPlazasClass(partida)">Plazas: {{ partida.plazas }}</p>
                <!-- Imagen de placeholder -->
                <div class="image-container" :class="getCancelledStatus(partida)">
                    <img src="/images/placeholder.jpg" alt="" class="game-image">
                </div>
                <!-- Título y fecha -->
                <p class="partida-title">Partida</p>
                <p class="partida-date">{{ partida.fecha }}</p>
                <!-- Botón de reservar -->
                <router-link :to="`/booking/${partida.fecha}`" class="reservar-button" :disabled="partida.plazas === 0">
                    {{ $t('booking') }}
                </router-link>
            </div>
        </div>

        <!-- Botones de navegación -->
        <div class="navigation-buttons">
            <button @click="prevGroup" :disabled="currentGroup === 0"><</button>
            <button @click="nextGroup" :disabled="currentGroup === totalGroups - 1">></button>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import axios from 'axios';

// Estado para almacenar las partidas
const partidas = ref([]);

// Índice del grupo actual
const currentGroup = ref(0);

// Tamaño del grupo (4 partidas por grupo)
const groupSize = 4;

// Obtener las partidas visibles según el grupo actual
const visibleGames = computed(() => {
    const start = currentGroup.value * groupSize;
    const end = start + groupSize;
    return partidas.value.slice(start, end);
});

// Calcular el número total de grupos
const totalGroups = computed(() => Math.ceil(partidas.value.length / groupSize));

// Función para obtener las partidas desde la API
const fetchPartidas = async () => {
    try {
        const response = await axios.get('api/partidas');
        partidas.value = response.data;
    } catch (error) {
        console.error('Error while obtaining matches:', error);
    }
};

// Navegar al grupo anterior
const prevGroup = () => {
    if (currentGroup.value > 0) {
        currentGroup.value--;
    }
};

// Navegar al siguiente grupo
const nextGroup = () => {
    if (currentGroup.value < totalGroups.value - 1) {
        currentGroup.value++;
    }
};

// Función para determinar el color de las plazas
const getPlazasClass = (partida) => {

    const plazas = partida.plazas;
    const cancelled = partida.cancelled;

    if (cancelled == 1){
        return ''
    }

    if (plazas === 0) {
        return 'card-full'; // Rojo si no hay plazas
    } else if (plazas <= 50) {
        return 'card-almost-full'; // Amarillo si quedan pocas plazas
    } else {
        return 'card-not-full'; // Verde si hay muchas plazas
    }
};

const  getCancelledStatus = (partida) => {
    const cancelled = partida.cancelled;

    return cancelled == 1 ? 'cancelled-image-container' : '';
}

// Cuando el componente se monta, cargar las partidas
onMounted(() => {
    fetchPartidas();
});
</script>

<style scoped>
.skiny-calendar-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    background-color: #283227;
    height: 800px;
    width: 30vw;
    border-radius: 4px;
    padding: 20px;
}

.skiny-calendar-div {
    gap: 65px;
    margin-bottom: 20px;
}

.game-card {
    background-color: #F8F8F8;
    border-radius: 4px;
    height: 300px;
    width: 200px;
    padding: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.plazas {
    font-size: 1.2em;
    font-weight: bold;
    margin-bottom: 10px;
}

.card-full {
    color: #ff0000; /* Rojo si no hay plazas */
}

.card-almost-full {
    color: #ffcc00; /* Amarillo si quedan pocas plazas */
}

.card-not-full {
    color: #4CAF50; /* Verde si hay muchas plazas */
}

.image-container{
    position: relative;
    display: inline-block;
    width: 100%;
    height: 40%;
}

.cancelled-image-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    pointer-events: none;
    background-image: url("/images/cancelled.svg");
    background-repeat: no-repeat;
    background-position: center;
}

.game-image {
    height: 100%;
    width: 100%;
    margin-bottom: 10px;
}

.partida-title {
    font-size: 1.5em;
    font-weight: bold;
    color: #283227;
    margin-bottom: 5px;
}

.partida-date {
    font-size: 1.1em;
    color: #555;
    margin-bottom: 15px;
}

.reservar-button {
    background-color: #283227; /* Verde para el botón */
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    font-size: 1em;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
}

.reservar-button:disabled {
    background-color: #ccc; /* Gris cuando está deshabilitado */
    cursor: not-allowed;
}

.reservar-button:hover:not(:disabled) {
    background-color: #45a049; /* Verde más oscuro al pasar el mouse */
}

.navigation-buttons {
    display: flex;
    gap: 10px;
}

.navigation-buttons button {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1em;
}

.navigation-buttons button:disabled {
    background-color: #ccc;
    cursor: not-allowed;
}
</style>
