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
                                <input type="text" id="DNI" v-model="DNI" required>
                            </div>

                            <div class="form-group bookingtextinput">
                                <label for="nombre">* Nombre completo</label>
                                <input type="text" id="nombre" v-model="nombrecompleto" required>
                            </div>

                            <div class="form-group bookingtextinput">
                                <label for="email">* Email</label>
                                <input type="email" id="email" v-model="email" required>
                            </div>

                            <div class="form-group bookingtextinput">
                                <label for="telefono">Teléfono</label>
                                <input type="tel" id="telefono" v-model="telefono" min="18">
                            </div>
                        </div>
                        <div class="formsplit">
                            <div class="form-group bookingcheckinput">
                                <div>
                                    <input type="checkbox" id="comida" v-model="food" >
                                    <label for="comida">Añadir bocadillo?</label>
                                </div>

                            </div>
                            <div class="form-group">
                                <select id="bocadillo"  v-model="bocadillo" :disabled="!food">
                                    <option value="1">01.- Lomo queso pan con tomate</option>
                                    <option value="2">02.- Bacon queso pan con tomate</option>
                                    <option value="3">03.- Tortilla queso pan con tomate</option>
                                    <option value="4">04.- Salchichas queso pan con tomate</option>
                                    <option value="7">07.- Fuet pan con tomate</option>
                                    <option value="8">08.- Jamon serrano pan con tomate</option>
                                    <option value="17">17.- Jamon serrano pan sin tomate</option>
                                </select>
                            </div>

                            <div class="form-group bookingtextinput bookingseparationup">
                                <label for="nombre">Tienes equipo? Escribe el nombre</label>
                                <input type="text" id="nombre" v-model="team">
                            </div>

                            <div class="form-group bookingcheckinput bookingseparationup">
                                <div>
                                    <input type="checkbox" id="alquiler" v-model="alquiler">
                                    <label for="alquiler">Alquilar equipamiento</label>

                                </div>
                            </div>

                            <div class="form-group bookingcheckinput bookingseparationup">
                                <div>
                                    <input type="checkbox" id="shift" v-model="shift">
                                    <label for="shift">Turno de tarde? (16:00)</label>

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
import {ref, onMounted, inject, computed} from 'vue';
import { useRoute, useRouter } from "vue-router";
import { authStore} from "@/store/auth.js"

const auth = authStore();
const authenticated = auth.authenticated;

    const post = ref();
    const categories = ref();
    const route = useRoute()
    const router = useRouter();
    const partida_id = route.params.id;
    const swal = inject('$swal');



    onMounted(() => {

    })

        // Variables reactivas
        const DNI = ref("");
        const nombrecompleto = ref("");
        const telefono = ref("");
        const email = ref("");
        const alquiler = ref(false);
        const food = ref(false);
        const bocadillo = ref(1)
        const shift = ref(false);

        const discountinput = ref("");
        const descuentoPorcentaje = ref(null);

        if (authenticated){
            const user = auth.user;

            DNI.value = user.DNI;
            nombrecompleto.value = user.fullname;
            telefono.value = user.phonenumber;
            email.value = user.email;
        }

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
                window.scrollTo(0, 0); // Hace scroll al inicio
            });
        }, 2500);


        // Limpiar los campos después de enviar
        DNI.value = "";
        nombrecompleto.value = "";
        telefono.value = "";
        email.value = "";
        food.value = false;
        bocadillo.value = 1;
        shift.value = false;

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
