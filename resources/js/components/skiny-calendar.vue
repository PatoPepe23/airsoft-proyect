<template>
    <div class="skiny-calendar-container">
        <div class="row row-cols-2 skiny-calendar-div justify-content-center">
            <div v-for="partida in visibleGames" :key="partida.id" class="col2 game-card">
                <p class="plazas" :class="getPlazasClass(partida)">Plazas: {{ partida.plazas }}</p>
                <div class="image-container" :class="getCancelledStatus(partida)">
                    <img src="/images/placeholder.jpg" alt="" class="game-image">
                </div>
                <p class="partida-title">Partida</p>
                <p class="partida-date">{{ formatDate(partida.fecha) }}</p>
                <router-link :to="`/booking/${formatDate(partida.fecha, '-')}`" class="reservar-button" :disabled="partida.plazas === 0">
                    {{ $t('booking') }}
                </router-link>
            </div>
        </div>

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

const data = async () => {
    return {
        currentDate: new Date(),
        daysOfWeek: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
        partidas: {}, // Almacena todas las partidas por fecha
        intervalId: null,

    };
}

// Función para obtener las partidas desde la API
const fetchPartidas = async () => {
    try {
        const response = await axios.get('/api/partidas?'
            + 'year=' + this.currentDate.getFullYear()
            + '&month=' + (this.currentDate.getMonth() + 1)
            + '&limitMonth=' + (this.currentDate.getMonth() + 4)
        );

        this.partidas = response.data.reduce((acc, item) => {
            const fecha = item.fecha;
            acc[fecha] = item;
            return acc;
        }, {});
    } catch (error) {
        console.error('Error fetching partidas:', error);
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

    if (cancelled == 1) {
        return '';
    }

    if (plazas === 0) {
        return 'card-full'; // Rojo si no hay plazas
    } else if (plazas <= 50) {
        return 'card-almost-full'; // Amarillo si quedan pocas plazas
    } else {
        return 'card-not-full'; // Verde si hay muchas plazas
    }
};

const getCancelledStatus = (partida) => {
    const cancelled = partida.cancelled;
    return cancelled == 1 ? 'cancelled-image-container' : '';
};

// Formatea la fecha de "yyyy-mm-dd" a "dd-mm-yyyy"
const formatDate = (dateStr, separator = '-') => {
    if (!dateStr) return '';
    const datePart = dateStr.split('T')[0]; // Extract 'YYYY-MM-DD'
    const [year, month, day] = datePart.split('-');
    return `<span class="math-inline">\{String\(Number\(day\)\)\.padStart\(2, '0'\)\}</span>{separator}<span class="math-inline">\{month\}</span>{separator}${year}`;
};

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
    height: auto; /* Ajustar altura automáticamente */
    width: 90vw; /* O el ancho que desees para móvil */
    border-radius: 4px;
    padding: 20px;
    margin: 20px auto; /* Centrar en la pantalla móvil */
}

.skiny-calendar-div {
    display: flex;
    flex-wrap: wrap; /* Permitir que las tarjetas se envuelvan */
    justify-content: center; /* Centrar las tarjetas */
    gap: 20px;
    margin-bottom: 20px;
}

.game-card {
    background-color: #F8F8F8;
    border-radius: 4px;
    height: auto; /* Ajustar altura automáticamente */
    width: calc(50% - 10px); /* Dos tarjetas por fila con un pequeño espacio */
    min-width: 150px; /* Ancho mínimo de la tarjeta */
    padding: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.plazas {
    font-size: 1.1em;
    font-weight: bold;
    margin-bottom: 5px;
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

.image-container {
    position: relative;
    width: 80%;
    height: auto;
    aspect-ratio: 1 / 0.6; /* Proporción de la imagen */
    margin-bottom: 10px;
    overflow: hidden; /* Recortar la imagen si no coincide la proporción */
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
    background-size: contain; /* Ajustar la imagen completamente dentro */
}

.game-image {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover; /* Cubrir el contenedor manteniendo la proporción */
}

.partida-title {
    font-size: 1.2em;
    font-weight: bold;
    color: #283227;
    margin-bottom: 3px;
}

.partida-date {
    font-size: 0.9em;
    color: #555;
    margin-bottom: 10px;
}

.reservar-button {
    background-color: #283227; /* Verde para el botón */
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 5px;
    font-size: 0.9em;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    width: 80%;
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
    margin-top: 15px;
}

.navigation-buttons button {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 0.9em;
}

.navigation-buttons button:disabled {
    background-color: #ccc;
    cursor: not-allowed;
}
</style>
