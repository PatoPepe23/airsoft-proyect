<template>
    <div>
        <router-view></router-view>

        <CookieConsent />

    </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { useRouter } from 'vue-router';
import useAuth from './composables/auth.js'; // Adjust the path as needed

// Your existing component import
import CookieConsent from './components/CookieConsent.vue';

const router = useRouter();
const { initSession } = useAuth();

onMounted(async () => {
    const sessionIsValid = await initSession();

    // Check if the current route is not 'login' to avoid an infinite loop
    if (!sessionIsValid && router.currentRoute.value.name !== 'login' && router.currentRoute.value.name !== 'home') {
        router.push({ name: 'login' });
    }
});
</script>
