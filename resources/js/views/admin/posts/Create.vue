<template>
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
</template>
<script setup>
import {onMounted, reactive, ref} from "vue";
import DropZone from "@/components/DropZone.vue";
import useCategories from "@/composables/categories";
import usePosts from "@/composables/posts";
import {useForm, useField, defineRule} from "vee-validate";
import {required, min} from "@/validation/rules"

defineRule('required', required)
defineRule('min', min);

const dropZoneActive = ref(true)

// Define a validation schema
const schema = {
    title: 'required|min:5',
    content: 'required|min:50',
    categories: 'required'
}
// Create a form context with the validation schema
const {validate, errors} = useForm({validationSchema: schema})
// Define actual fields for validation
const {value: title} = useField('title', null, {initialValue: ''});
const {value: content} = useField('content', null, {initialValue: ''});
const {value: categories} = useField('categories', null, {initialValue: '', label: 'category'});
const {categoryList, getCategoryList} = useCategories()
const {storePost, validationErrors, isLoading} = usePosts()
const post = reactive({
    title,
    content,
    categories,
    thumbnail: ''
})

const thefile = ref('')

function submitForm() {
    validate().then(form => {
        if (form.valid) storePost(post)
    })
}

onMounted(() => {
    getCategoryList()
})

</script>
