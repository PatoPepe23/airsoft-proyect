<template>
    <div class="container">
        <div class="nav-avoid">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><router-link to="/">{{ $t('home') }}</router-link></li>
                    <li class="breadcrumb-item"><router-link to="/booking">{{ $t('booking') }}</router-link></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ route.params.id }}</li> </ol>
            </nav>
            <h1>{{ $t('booking') }} {{ route.params.id }}</h1> <div class="bookingform">
            <form @submit.prevent="reservar">
                <div class="bookingformleft">
                    <div class="formsplit">
                        <div class="form-group bookingtextinput">
                            <label for="DNI">* DNI</label>
                            <input type="text" id="DNI" v-model="DNI" @input="saveToCookie('DNI')" required>
                        </div>

                        <div class="form-group bookingtextinput">
                            <label for="nombre">* Nombre completo</label>
                            <input type="text" id="nombre" v-model="nombrecompleto" @input="saveToCookie('nombrecompleto')" required>
                        </div>

                        <div class="form-group bookingtextinput">
                            <label for="email">* Email</label>
                            <input type="email" id="email" v-model="email" @input="saveToCookie('email')" required>
                        </div>

                        <div class="form-group bookingtextinput">
                            <label for="telefono">Teléfono</label>
                            <input type="tel" id="telefono" v-model="telefono" @input="saveToCookie('telefono')" min="18">
                        </div>
                    </div>
                    <div class="formsplit">
                        <div class="form-group bookingtextinput bookingseparationup">
                            <label for="nombre">¿Tienes equipo? Escribe el nombre</label>
                            <input type="text" id="nombre" v-model="team" @input="saveToCookie('team')">
                        </div>

                        <div class="form-group bookingcheckinput bookingseparationup">
                            <div>
                                <input type="checkbox" id="alquiler" v-model="alquiler">
                                <label for="alquiler">Alquilar equipamiento</label>
                            </div>
                        </div>
                        <p>* Si deseas comprar un bocadillo, deberás ir a Organización del campo.</p>
                    </div>

                </div>

                <div class="bookingformright">
                    <div>
                        <h2>Información de la reserva</h2>
                        <p>Alquiler: {{ alquiler ? 'Sí ' : 'No ' }}<span class="precio">{{ alquiler ? '+ 25€' : '+ 0€' }}</span></p>
                        <p>Día: <span class="precio">{{ route.params.id }}</span></p> <p>Hora: <span class="precio">{{ shift ? '16:00' : '8:00' }}</span></p>
                    </div>
                    <div class="bookingconfirmation">
                        <form @submit.prevent="discount" class="formdiscount">
                            <input type="text" id="discount" v-model="discountinput" placeholder="Discount code"><button type="submit">Aplicar</button>
                        </form>
                        <p>Total: <span class="precio">{{precio}} €</span> <span v-if="descuentoPorcentaje" class="old">{{base}} €</span></p>
                        <button type="submit">Reservar</button>
                    </div>
                </div>
            </form>
        </div>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios';
import { ref, onMounted, inject, computed, watch } from 'vue';
import { useRoute, useRouter } from "vue-router";
import { authStore} from "@/store/auth.js"
import Cookies from 'js-cookie';
import { useCookieConsentStore } from '@/store/cookieConsent';
import useReservas from "@/composables/reservas.js";


const auth = authStore();
const authenticated = auth.authenticated;

const route = useRoute() // Correctly using useRoute() for Composition API
const router = useRouter();
// const partida_id = route.params.id; // And correctly using 'route' here
const swal = inject('$swal');
const {discount, reservar, DNI, food, team, shift, bocadillo, alquiler, email, telefono, nombrecompleto, partida_id, descuentoPorcentaje, discountinput, precio} = useReservas(swal);

const cookieConsentStore = useCookieConsentStore();

// Cookie Configuration
const COOKIE_PREFIX = 'airsoft_booking_';
const COOKIE_OPTIONS = { expires: 1, sameSite: 'Lax', secure: false };

// Cooki Functions

/**
 * Saves a specific form field's value to a cookie.
 * @param {string} fieldName - The name of the reactive variable (e.g., 'DNI', 'email').
 */
const saveToCookie = (fieldName) => {
    if (!cookieConsentStore.hasConsentForPreferences){
        console.log(`Consent not given for saving cookie: ${COOKIE_PREFIX}${fieldName}`);
        return;
    }

    const value = eval(fieldName).value; // Access the ref's value

    if (value !== null && value !== undefined && value !== '') {
        Cookies.set(COOKIE_PREFIX + fieldName, value, COOKIE_OPTIONS);
    } else {
        Cookies.remove(COOKIE_PREFIX + fieldName);
    }
};

/**
 * Loads values from cookies and populates the form fields.
 */
const loadFromCookies = () => {
    if (!cookieConsentStore.hasConsentForPreferences){
        console.log('Consent not given for loading preferences cookies.');
        return;
    }

    const fieldsToLoad = [
        'DNI', 'nombrecompleto', 'email', 'telefono', 'team'
    ];

    fieldsToLoad.forEach(fieldName => {
        const cookieValue = Cookies.get(COOKIE_PREFIX + fieldName);
        if (cookieValue) {
            eval(fieldName).value = cookieValue;
        }
    });

    const alquilerCookie = Cookies.get(COOKIE_PREFIX + 'alquiler');
    if (alquilerCookie === 'true') {
        alquiler.value = true;
    } else if (alquilerCookie === 'false') {
        alquiler.value = false;
    }

    const shiftCookie = Cookies.get(COOKIE_PREFIX + 'shift');
    if (shiftCookie === 'true') {
        shift.value = true;
    } else if (shiftCookie === 'false') {
        shift.value = false;
    }

    const foodCookie = Cookies.get(COOKIE_PREFIX + 'food');
    if (foodCookie === 'true') {
        food.value = true;
    } else if (foodCookie === 'false') {
        food.value = false;
    }

    const bocadilloCookie = Cookies.get(COOKIE_PREFIX + 'bocadillo');
    if (bocadilloCookie) {
        bocadillo.value = parseInt(bocadilloCookie);
    }
};

watch(alquiler, (newValue) => {
    saveToCookie('alquiler');
});

watch(shift, (newValue) => {
    saveToCookie('shift');
});

watch(food, (newValue) => {
    saveToCookie('food');
});

watch(bocadillo, (newValue) => {
    saveToCookie('bocadillo');
});

watch(() => cookieConsentStore.hasConsentForPreferences, (newValue) => {
    if (newValue === true) {
        console.log('Consent just granted. Attempting to load cookies now.');
        loadFromCookies();
    }
});


onMounted(() => {
    partida_id.value = route.params.id
    if (authenticated && auth.user) {
        DNI.value = auth.user.DNI || DNI.value;
        nombrecompleto.value = auth.user.fullname || nombrecompleto.value;
        telefono.value = auth.user.phonenumber || telefono.value;
        email.value = auth.user.email || email.value;
    } else {
        loadFromCookies();
    }
});

</script>
