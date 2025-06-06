<template>
    <div class="container flex">
        <div class="nav-avoid">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><router-link to="/">{{ $t('home') }}</router-link></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $t('booking') }}</li>
                </ol>
            </nav>
        </div>
        <div class="flex">
            <div class="d-none d-lg-flex">
                <selfCalendar/>
            </div>
            <div class="d-lg-none">
                <skinyCalendar/>
            </div>
            <div class="booking-title d-none d-lg-flex">

                <div class="booking-backgroundtitle">

                    <div class="booking-whitebackgroundtitle">
                        <h1>{{ $t('how_to_book') }}:</h1>
                        <h3>{{ $t('booking_instructions') }}</h3>{{ $t('booking_instructions1') }}
                        <h3>Presiona ← o → para navegar por los meses</h3>
                        <h3>Presiona "Hoy" para redirigirte al mes que estamos</h3>
                    </div>
                    <div class="booking-whitebackgroundtitle">
                        <h1>Leyenda de colores:</h1>
                        <h3>🟩 Plazas disponibles</h3>
                        <h3>🟨 Pocas plazas disponibles</h3>
                        <h3>🟥 No hay plazas </h3>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script setup>
import axios from 'axios';
import {ref, onMounted} from 'vue';
import selfCalendar from './../../components/Calendar.vue';
import skinyCalendar from './../../components/skiny-calendar.vue';

const posts = ref();

function getImageUrl(post) {
    let image
    if (post.resized_image.length > 0) {
        image = post.resized_image
    } else {
        image = post.original_image
    }
    return new URL(image, import.meta.url).href
}

onMounted(() => {
    axios.get('/api/get-posts').then(({data}) => {
        posts.value = data;
    })
})

</script>
