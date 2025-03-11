<template>
    <div>
    <Navbar/>
    <router-view></router-view>
    <AppFooter/>
    </div>
</template>
<script setup>
import Navbar from './Nav.vue';
import AppFooter from './AppFooter.vue';

</script>
