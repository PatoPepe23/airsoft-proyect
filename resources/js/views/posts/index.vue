<template>
    <div class="container">
        <div class="nav-avoid">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><router-link to="/">{{ $t('home') }}</router-link></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $t('booking') }}</li>
                </ol>
            </nav>
            <h1>{{ $t('booking') }}</h1>
        </div>
        <selfCalendar/>
    </div>
</template>

<script setup>
import axios from 'axios';
import {ref, onMounted} from 'vue';
import selfCalendar from './../../components/Calendar.vue';

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
