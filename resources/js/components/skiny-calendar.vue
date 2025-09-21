<template>
    <div class="skiny-calendar-container">
        <div class="row row-cols-2 skiny-calendar-div justify-content-center">
            <div v-for="partida in visibleGames" :key="partida.id" class="col2 game-card">
                <p class="plazas" :class="getPlazasClass(partida)">
                    <span v-if="partida.plazas === 0">No hay plazas disponibles</span>
                    <span v-else-if="partida.plazas < 50">Pocas plazas disponibles </span>
                    <span v-else>Plazas disponibles</span>
                </p>

                <div class="image-container" :class="getCancelledStatus(partida)">
                    <img src="/images/masiabach.webp" alt="" class="game-image">
                </div>
                <p class="partida-title">{{ formatDate(partida.fecha) }}</p>
                <p class="partida-date">{{$t('ticket_text2')}}</p>
                <router-link
                    :to="`/booking/${formatDate(partida.fecha, '-')}`"
                    class="reservar-button"
                    :class="{ 'disabled-link':isPastDate(partida.fecha) }"
                >
                    {{ $t('booking') }}
                </router-link>

                <p v-if="isPastDate(partida.fecha)" class="expired-text">
                    Partida expirada
                </p>
            </div>
        </div>

        <div class="navigation-buttons">
            <button @click="prevGroup" :disabled="currentGroup === 0"><</button>
            <p v-if="currentGroup > 0" class="pageNumberBefore">{{ currentGroup}}</p>
            <p class="pageNumber">{{ currentGroup + 1}}</p>
            <p v-if="currentGroup < totalGroups - 1" class="pageNumberAfter">{{ currentGroup + 2}}</p>
            <button @click="nextGroup" :disabled="currentGroup === totalGroups - 1">></button>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from "vue";
import axios from 'axios';

const partidas = ref([]);
const currentGroup = ref(0);
const groupSize = 4;
const currentDate = ref(new Date());

const upcomingGames = computed(() => {
    const now = new Date();

    return partidas.value.filter(partida => {
        if (!partida.fecha) return false;

        const partidaDate = new Date(partida.fecha);

        // Establecemos la hora límite: domingo a las 12:00
        // Si es domingo, fijamos horas a las 12:00 del mediodía
        if (partidaDate.getDay() === 0) { // domingo = 0
            partidaDate.setHours(12, 0, 0, 0);
        } else {
            // Para otros días, se considera hasta final del día
            partidaDate.setHours(23, 59, 59, 999);
        }

        return partidaDate >= now;
    });
});

const visibleGames = computed(() => {
    const start = currentGroup.value * groupSize;
    const end = start + groupSize;
    return upcomingGames.value.slice(start, end);
});

const totalGroups = computed(() => Math.ceil(upcomingGames.value.length / groupSize));

const fetchPartidas = async () => {
    try {
        const response = await axios.get('/api/partidas?'
            + 'year=' + currentDate.value.getFullYear()
            + '&month=' + (currentDate.value.getMonth() + 1)
            + '&limitMonth=' + (currentDate.value.getMonth() + 4)
        );

        partidas.value = response.data;
        console.log('Fetched partidas:', partidas.value);
    } catch (error) {
        console.error('Error fetching partidas:', error);
    }
};

const prevGroup = () => {
    if (currentGroup.value > 0) {
        currentGroup.value--;
    }
};

const nextGroup = () => {
    if (currentGroup.value < totalGroups.value - 1) {
        currentGroup.value++;
    }
};

const getPlazasClass = (partida) => {
    const plazas = partida.plazas;
    const cancelled = partida.cancelled;

    if (cancelled == 1) {
        return '';
    }

    if (plazas === 0) {
        return 'card-full';
    } else if (plazas <= 50) {
        return 'card-almost-full';
    } else {
        return 'card-not-full';
    }
};

const getCancelledStatus = (partida) => {
    const cancelled = partida.cancelled;
    return cancelled == 1 ? 'cancelled-image-container' : '';
};

const formatDate = (dateStr, separator = '-') => {
    if (!dateStr) return '';
    const datePart = dateStr.split('T')[0];
    const [year, month, day] = datePart.split('-');
    return `${String(Number(day)).padStart(2, '0')}${separator}${month}${separator}${year}`;
};

// Función para comprobar si la fecha ya pasó
const isPastDate = (fechaStr) => {
    if (!fechaStr) return false;

    const partidaDate = new Date(fechaStr);
    partidaDate.setHours(12, 0, 0, 0);

    const now = new Date();

    return partidaDate < now;
};

let intervalId = null;

onMounted(() => {
    fetchPartidas();
    intervalId = setInterval(() => fetchPartidas(), 5000);
});

onBeforeUnmount(() => {
    clearInterval(intervalId);
    console.log('Interval cleared!');
});
</script>

<style scoped>
.skiny-calendar-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    background-color: #283227;
    height: auto;
    width: 90vw;
    border-radius: 4px;
    padding: 20px;
    margin: 20px auto;
}

.skiny-calendar-div {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
    margin-bottom: 20px;
}

.game-card {
    background-color: #F8F8F8;
    border-radius: 4px;
    height: auto;
    width: calc(50% - 10px);
    min-width: 150px;
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
    color: #ff0000;
}

.card-almost-full {
    color: #ffcc00;
}

.card-not-full {
    color: #4CAF50;
}

.image-container {
    position: relative;
    width: 80%;
    height: auto;
    aspect-ratio: 1 / 0.6;
    margin-bottom: 10px;
    overflow: hidden;
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
    background-size: contain;
}

.game-image {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
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
    background-color: #283227;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 5px;
    font-size: 0.9em;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    width: 80%;
    text-align: center;
}

.reservar-button:disabled {
    background-color: #ccc;
    cursor: not-allowed;
}

.reservar-button:hover:not(:disabled) {
    background-color: #45a049;
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

.pageNumber{
    display: flex;
    color: #ffcc00;
    border-bottom: 1px solid ;
}

.pageNumberBefore{
    display: flex;
    color: #F8F8F8;
}

.pageNumberAfter{
    display: flex;
    color: #F8F8F8;
}

.expired-text {
    color: #ff0000;
    font-size: 0.8em;
    margin-top: 5px;
}

.disabled-link {
    pointer-events: none;  /* Desactiva clics */
    background-color: #ccc;
    cursor: not-allowed;
}
</style>
