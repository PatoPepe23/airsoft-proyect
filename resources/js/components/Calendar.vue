<template>
    <div class="calendar">
        <div class="calendar-header">
            <button class="month-selector" @click="prevMonth">←</button>
            <h2>{{ currentMonth }} {{ currentYear }}</h2>
            <button class="month-selector" @click="nextMonth">→</button>
            <button @click="goToCurrentDate" class="normal-button current-date-button">{{ $t('today') }}</button>
        </div>
        <div class="calendar-grid">
            <div v-for="day in daysOfWeek" :key="day" class="calendar-day-header">
                {{ day }}
            </div>
            <div
                v-for="(day, index) in days"
                :key="day.date"
                class="calendar-day"
                :class="[
                    { 'outside-month': !day.isCurrentMonth },
                    getDayClass(day.date, day.isCurrentMonth).class, // Clase dinámica basada en las plazas, cancelled y tipo
                    { 'row-even': Math.floor(index / 7) % 2 === 0, 'row-odd': Math.floor(index / 7) % 2 !== 0 } // Alternar colores de filas
                ]"
            >
                <template v-if="isWeekend(day.date) && day.isCurrentMonth">
                    <button
                        @click="redirectToBooking(day.date)"
                        class="calendar-day-weekend-button"
                        :disabled="getDayClass(day.date, day.isCurrentMonth).disabled"
                    >
                        {{ day.day }}
                    </button>
                </template>
                <template v-else>
                    {{ day.day }}
                </template>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            currentDate: new Date(),
            daysOfWeek: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
            partidas: {}, // Almacena todas las partidas por fecha
            intervalId: null,

        };
    },
    computed: {
        currentYear() {
            return this.currentDate.getFullYear();
        },
        currentMonth() {
            return this.currentDate.toLocaleString('default', { month: 'long' });
        },
        days() {
            const year = this.currentDate.getFullYear();
            const month = this.currentDate.getMonth();
            const firstDayOfMonth = new Date(year, month, 1);
            const lastDayOfMonth = new Date(year, month + 1, 0);
            const daysInMonth = lastDayOfMonth.getDate();
            const startDay = (firstDayOfMonth.getDay() + 6) % 7; // Ajuste para que empiece en lunes

            const days = [];

            // Días del mes anterior
            const prevMonthLastDay = new Date(year, month, 0).getDate();
            for (let i = startDay; i > 0; i--) {
                days.push({
                    day: prevMonthLastDay - i + 1,
                    date: new Date(year, month - 1, prevMonthLastDay - i + 1),
                    isCurrentMonth: false,
                });
            }

            // Días del mes actual
            for (let i = 1; i <= daysInMonth; i++) {
                days.push({
                    day: i,
                    date: new Date(year, month, i),
                    isCurrentMonth: true,
                });
            }

            // Días del siguiente mes (solo los necesarios para completar 5 filas)
            const totalDays = 35 - days.length;
            for (let i = 1; i <= totalDays; i++) {
                days.push({
                    day: i,
                    date: new Date(year, month + 1, i),
                    isCurrentMonth: false,
                });
            }

            return days;
        },
    },
    methods: {
        prevMonth() {
            this.currentDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() - 1, 1);
            this.fetchPartidas(); // Recargar las partidas al cambiar de mes
        },
        nextMonth() {
            this.currentDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() + 1, 1);
            this.fetchPartidas(); // Recargar las partidas al cambiar de mes
        },
        goToCurrentDate() {
            this.currentDate = new Date(); // Establece la fecha actual
            this.fetchPartidas(); // Recargar las partidas al volver a la fecha actual
        },
        isWeekend(date) {
            const dayOfWeek = date.getDay(); // 0 (domingo) a 6 (sábado)
            return dayOfWeek === 0 || dayOfWeek === 6; // Domingo (0) o sábado (6)
        },
        formatDate(date) {
            // Formatea la fecha como dd-mm-yyyy
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Los meses van de 0 a 11
            const year = date.getFullYear();
            return `${day}-${month}-${year}`; // Usamos guiones como separadores
        },
        redirectToBooking(date) {
            const dayId = this.formatDate(date); // Formato dd-mm-yyyy
            this.$router.push(`/booking/${dayId}`); // Navegación con Vue Router
        },
        async fetchPartidas() {
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
        },
        formatApiDate(fecha) {
            // Convertir fecha de "dd-mm-yyyy" a "yyyy-mm-dd"
            const [day, month, year] = fecha.split('-');
            const adjustedDay = String(Number(day)).padStart(2, '0'); // Restar 1 y asegurar dos dígitos
            return `${year}-${month}-${adjustedDay}`;
        },
        getDayClass(date, isCurrentMonth) {
            const today = new Date().toISOString().split('T')[0];
            const dateString = date.toISOString().split('T')[0];

            if (!isCurrentMonth) {
                return { class: '', disabled: true }; // No colorear días fuera del mes actual y deshabilitar
            }

            if (dateString < today && this.isWeekend(date)) {
                return { class: 'past-day', disabled: true };
            }

            const formatedDate = this.formatApiDate(this.formatDate(date)); // Formatear la fecha correctamente
            const partida = this.partidas[formatedDate]; // Obtiene la partida para la fecha

            if (partida) {
                if (this.isWeekend(date)) {
                    const plazas = partida.plazas;

                    if (partida.cancelled == 1) {
                        return { class: 'cancelled', disabled: true }; // Clase para partidas canceladas y deshabilitar
                    }

                    if (plazas === 0) {
                        return { class: 'full', disabled: true }; // Clase para cuando no hay plazas disponibles y deshabilitar
                    } else if (plazas <= 50) {
                        return { class: 'almost-full', disabled: false }; // Clase para cuando quedan pocas plazas
                    } else {
                        return { class: 'not-full', disabled: false }; // Clase para cuando hay muchas plazas disponibles
                    }
                }
            }

            return { class: '', disabled: false }; // No hay clase si no es fin de semana o no hay partida
        },
    },
    mounted() {
        this.fetchPartidas(); // Obtener las partidas al cargar el componente
        this.intervalId = setInterval(() => this.fetchPartidas(), 5000);
    },
    beforeUnmount() {
        clearInterval(this.intervalId);
    },
};
</script>

<style>
.calendar {
    max-width: 800px;
    min-height: 700px;
    margin: 0 auto;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

.calendar-header {
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 1.5em;
}

.calendar-header button {
    background: none;
    border: none;
    font-size: 32px;
    cursor: pointer;
}

.month-selector:hover {
    transition: 0.5S;
    transform: scale(1.1);
}

.current-date-button {
    position: page;
    padding: 0 25px;
    font-size: 1.2em !important;
    left: 30%;
}

.calendar-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 1px;
    padding: 5px;
    flex-grow: 1;
}

.calendar-day-header {
    text-align: center;
    align-content: center;
    font-weight: bold;
    padding: 30px;
    background-color: #283227;
    color: #F8F8F8;
    font-size: 1.8em;
}

.calendar-day-weekend-button {
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
    border: none;
    background: none;
    cursor: pointer;
    font-size: 1em;
    display: flex;
    align-items: center;
    justify-content: center;
}

.calendar-day-weekend-button:disabled {
    cursor: not-allowed;
    opacity: 0.6;
}

.calendar-day {
    text-align: center;
    padding: 30px;
    position: relative;
    font-size: 2.2em;
    display: flex;
    align-items: center;
    justify-content: center;
}

.calendar-day.outside-month {
    color: #ccc;
    cursor: default;
}

/* Alternar colores de filas */
.row-even {
    background-color: #D9D9D9;
}

.row-odd {
    background-color: #c6c6c6;
}

/* Clases dinámicas */
.full {
    background-color: #EC9494;
}

.almost-full {
    background-color: #ECD894;
}

.not-full {
    background-color: #94E890;
}

.cancelled {
    background-color: #6D6D6D;
    background-image: url("/public/images/cancelled.svg");
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
}

.past-day {
    background-color: #717171;
}
</style>
