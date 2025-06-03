<template>
    <div class="container">
        <div class="nav-avoid">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><router-link to="/">{{ $t('home') }}</router-link></li>
                    <li class="breadcrumb-item"><router-link to="/booking">{{ $t('booking') }}</router-link></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ this.$route.params.id }}</li>
                </ol>
            </nav>
            <h1>{{ $t('booking') }} {{this.$route.params.id}}</h1>

            <div class="bookingform">
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
                                <label for="nombre">Tienes equipo? Escribe el nombre</label>
                                <input type="text" id="nombre" v-model="team" @input="saveToCookie('team')">
                            </div>

                            <div class="form-group bookingcheckinput bookingseparationup">
                                <div>
                                    <input type="checkbox" id="alquiler" v-model="alquiler">
                                    <label for="alquiler">Alquilar equipamiento</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bookingformright">
                        <div>
                            <h2>Información de la reserva</h2>
                            <p>Bocata: {{ food ? 'Sí ' : 'No ' }}<span class="precio">{{ food ? '+ 6€' : '+ 0€' }}</span></p>
                            <p>Alquiler: {{ alquiler ? 'Sí ' : 'No ' }}<span class="precio">{{ alquiler ? '+ 25€' : '+ 0€' }}</span></p>
                            <p>Jugadores: <span class="precio">1</span></p>
                            <p>Hora: <span class="precio">{{ shift ? '16:00' : '8:00' }}</span></p>
                        </div>
                        <div class="bookingconfirmation">
                            <form @submit.prevent="discount">
                                <input type="text" id="discount" v-model="discountinput" placeholder="Discount code">
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


const auth = authStore();
const authenticated = auth.authenticated;

const route = useRoute()
const router = useRouter();
const partida_id = route.params.id;
const swal = inject('$swal');

const cookieConsentStore = useCookieConsentStore();

const DNI = ref("");
const nombrecompleto = ref("");
const telefono = ref("");
const email = ref("");
const alquiler = ref(false);
const team = ref("");
const food = ref(false);
const bocadillo = ref(1)
const shift = ref(false); // Checkbox

const discountinput = ref("");
const descuentoPorcentaje = ref(null);

// Cookie Configuration
const COOKIE_PREFIX = 'airsoft_booking_';
const COOKIE_OPTIONS = { expires: 1, sameSite: 'Lax', secure: true };

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
    if (authenticated && auth.user) {
        DNI.value = auth.user.DNI || DNI.value;
        nombrecompleto.value = auth.user.fullname || nombrecompleto.value;
        telefono.value = auth.user.phonenumber || telefono.value;
        email.value = auth.user.email || email.value;
    } else {
        loadFromCookies();
    }
});


const base = computed(() => {
    let b = 15;

    if (alquiler.value) {
        b = 40;
    }

    if (food.value) {
        b += 6;
    }

    return b;
});

const precio = computed(() => {
    if (descuentoPorcentaje.value) {
        return base.value - (base.value * descuentoPorcentaje.value / 100);
    }
    return base.value;
});

const discount = async () => {
    try {
        const response = await axios.post('/api/discount', {
            discountinput: discountinput.value
        });

        descuentoPorcentaje.value = response.data.porcentaje;

        swal({
            icon: 'success',
            title: 'Descuento aplicado correctamente',
            showConfirmButton: false,
            timer: 2500
        });
    } catch (error) {
        console.error("Error al conseguir el descuento:", error.response?.data || error);
        descuentoPorcentaje.value = 0;
        swal({
            icon: 'error',
            title: "Error al conseguir el descuento/No existe el descuento",
            showConfirmButton: false,
            timer: 2500
        });
    }
};

const reservar = async () => {
    try {
        const response = await axios.post('/api/reservar', {
            DNI: DNI.value,
            nombrecompleto: nombrecompleto.value,
            telefono: telefono.value,
            email: email.value,
            alquiler: alquiler.value,
            food: food.value,
            food_id: bocadillo.value,
            partida_id: partida_id,
            shift: shift.value,
            precio: precio.value,
            dentro: false
        });

        swal({
            icon: 'success',
            title: 'Reserva realizada con exito',
            showConfirmButton: false,
            timer: 2500
        });

        await axios.post('/api/send-mail', {
            DNI: DNI.value,
            nombrecompleto: nombrecompleto.value,
            telefono: telefono.value,
            email: email.value,
            alquiler: alquiler.value,
            food: food.value,
            food_id:bocadillo.value,
            shift: shift.value,
            subject: 'Confirmación de reserva',
            body: `Gracias por tu reserva, ${nombrecompleto.value}. Nos vemos pronto.`,
            precio: precio.value,
            partida_id: partida_id
        })

        setTimeout(() => {
            router.push({ name: 'home' }).then(() => {
                window.scrollTo(0, 0); // Scroll to top
            });
        }, 2500);

        // Clear all pre-population cookies after a successful reservation
        const fieldsToClear = [
            'DNI', 'nombrecompleto', 'email', 'telefono', 'team', 'alquiler', 'shift', 'food', 'bocadillo'
        ];
        fieldsToClear.forEach(fieldName => {
            Cookies.remove(COOKIE_PREFIX + fieldName);
        });

        // Reset local reactive variables to their initial state
        DNI.value = "";
        nombrecompleto.value = "";
        telefono.value = "";
        email.value = "";
        food.value = false;
        bocadillo.value = 1;
        shift.value = false;
        alquiler.value = false;
        team.value = "";

    } catch (error) {
        console.error("Error al enviar el formulario:", error.response?.data || error);
        swal({
            icon: 'error',
            title: error.response?.data.message,
            showConfirmButton: false,
            //timer: 2500
        });
    }
};
</script>
