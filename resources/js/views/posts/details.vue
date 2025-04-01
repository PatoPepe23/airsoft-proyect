<template>
    <div class="container">
        <div class="container">
            <div class="nav-avoid">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><router-link to="/">{{ $t('home') }}</router-link></li>
                        <li class="breadcrumb-item"><router-link to="/booking">{{ $t('booking') }}</router-link></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ this.$route.params.id }}</li>
                    </ol>
                </nav>
                <h1>{{ $t('booking') }}</h1>


                <form @submit.prevent="reservar">
                    <div class="form-group">
                        <label for="DNI">* DNI:</label>
                        <input type="text" id="DNI" v-model="DNI" required />
                    </div>

                    <div class="form-group">
                        <label for="nombre">* Nombre completo:</label>
                        <input type="text" id="nombre" v-model="nombrecompleto" required />
                    </div>

                    <div class="form-group">
                        <label for="email">* Email:</label>
                        <input type="email" id="email" v-model="email" required />
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono:</label>
                        <input type="tel" id="telefono" v-model="telefono" min="18" />
                    </div>

                    <div class="form-group">
                        <input type="checkbox" id="comida" v-model="food" >
                        <label for="comida">Añadir bocadillo?</label>
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

                    <div class="form-group">
                        <label for="nombre">Tienes equipo? Escribe el nombre:</label>
                        <input type="text" id="nombre" v-model="team" />
                    </div>

                    <div class="form-group">
                        <input type="checkbox" id="alquiler" v-model="alquiler" >
                        <label for="alquiler">Equipamiento de alquiler?</label>
                    </div>

                    <div class="form-group">
                        <input type="checkbox" id="shift" v-model="shift" >
                        <label for="shift">Turno de tarde? (16:00)</label>
                    </div>

                    <button type="submit">Enviar</button>
                </form>



            </div>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios';
import {ref, onMounted, inject} from 'vue';
import { useRoute, useRouter } from "vue-router";



    const post = ref();
    const categories = ref();
    const route = useRoute()
    const router = useRouter();
    const partida_id = route.params.id;
    const swal = inject('$swal')

    onMounted(() => {
        axios.get('/api/get-post/' + route.params.id).then(({ data }) => {
            post.value = data;
            verifysunday(partida_id);
        })
        axios.get('/api/category-list').then(({ data }) => {
            categories.value = data.data
        })
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

const reservar = async () => {
    try {
        const response = await axios.post('/api/reservar', {
            DNI: DNI.value,
            nombrecompleto: nombrecompleto.value,
            telefono: telefono.value,
            email: email.value,
            alquiler: alquiler.value,
            food: food.value,
            food_id: food.value ? bocadillo.value : null,
            partida_id: partida_id,
            shift: shift.value
        });

        swal({
            icon: 'success',
            title: 'Reserva realizada con exito',
            showConfirmButton: false,
            timer: 2500
        });
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
            timer: 2500
        });
    }
};


</script>
