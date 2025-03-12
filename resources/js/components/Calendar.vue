<template>
    <div class="calendar">
        <div class="calendar-header">
            <button @click="prevMonth">←</button>
            <h2>{{ currentMonth }} {{ currentYear }}</h2>
            <button @click="nextMonth">→</button>
        </div>
        <div class="calendar-grid">
            <div v-for="day in daysOfWeek" :key="day" class="calendar-day-header">
                {{ day }}
            </div>
            <div
                v-for="day in days"
                :key="day.date"
                class="calendar-day"
                :class="[
          { 'outside-month': !day.isCurrentMonth },
          getDayClass(day.date) // Clase dinámica basada en el número de plazas
        ]"
            >
                <template v-if="isWeekend(day.date) && day.isCurrentMonth">
                    <button @click="redirectToBooking(day.date)">
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
            specialDays: [], // Almacena los días especiales desde la base de datos
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
            for (let i = startDay - 1; i >= 0; i--) {
                days.push({
                    day: prevMonthLastDay - i,
                    date: new Date(year, month - 1, prevMonthLastDay - i),
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

            // Días del siguiente mes
            const nextMonthDays = 42 - days.length; // 6 semanas * 7 días = 42
            for (let i = 1; i <= nextMonthDays; i++) {
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
            this.fetchSpecialDays(); // Recargar los días especiales al cambiar de mes
        },
        nextMonth() {
            this.currentDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() + 1, 1);
            this.fetchSpecialDays(); // Recargar los días especiales al cambiar de mes
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
        async fetchSpecialDays() {
            try {
                const response = await axios.get('/api/special-days');
                this.specialDays = response.data; // Almacena los días especiales
            } catch (error) {
                console.error('Error fetching special days:', error);
            }
        },
        getDayClass(date) {
            const formattedDate = date.toISOString().split('T')[0]; // Formato YYYY-MM-DD
            const specialDay = this.specialDays.find(d => d.date === formattedDate);

            if (specialDay) {
                const plazas = specialDay.plazas; // Usamos el campo 'plazas'

                if (plazas === 0) {
                    return 'full'; // Clase para cuando no hay plazas disponibles
                } else if (plazas < 50) {
                    return 'almost-full'; // Clase para cuando quedan pocas plazas
                } else {
                    return 'not-full'; // Clase para cuando hay muchas plazas disponibles
                }
            }

            return ''; // No hay clase si no hay coincidencia
        },
    },
    mounted() {
        this.fetchSpecialDays(); // Obtener los días especiales al cargar el componente
    },
};
</script>

<style>
.calendar {
    font-family: Arial, sans-serif;
    max-width: 400px;
    margin: 0 auto;
    border: 1px solid #ccc;
    border-radius: 8px;
    overflow: hidden;
}

.calendar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    background-color: #f0f0f0;
    border-bottom: 1px solid #ccc;
}

.calendar-header button {
    background: none;
    border: none;
    font-size: 18px;
    cursor: pointer;
}

.calendar-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 5px;
    padding: 10px;
}

.calendar-day-header {
    text-align: center;
    font-weight: bold;
    padding: 5px;
    background-color: #f9f9f9;
}

.calendar-day {
    text-align: center;
    padding: 10px;
    border: 1px solid #eee;
    cursor: pointer;
}

.calendar-day.outside-month {
    color: #ccc;
    cursor: default;
}

.calendar-day button {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 16px;
    color: inherit;
}

.calendar-day button:hover {
    text-decoration: underline;
}

/* Clases dinámicas */
.full {
    background-color: #EC9494; /* Rojo claro */
}

.almost-full {
    background-color: #ECD894; /* Amarillo claro */
}

.not-full {
    background-color: #94E890; /* Verde claro */
}

.cancelled {
    background-color: #6D6D6D; /* Gris */
}
</style>
