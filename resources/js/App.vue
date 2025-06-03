<template>
    <div>
        <router-view></router-view>

        <CookieConsent />

    </div>
</template>

<script setup>
import CookieConsent from './components/CookieConsent.vue';
</script>
