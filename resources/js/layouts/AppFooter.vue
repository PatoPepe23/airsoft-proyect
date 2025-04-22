<script setup>
import { useLayout } from '../composables/layout';
import { computed } from 'vue';

const { layoutConfig } = useLayout();

const logoUrl = computed(() => {
    return `layout/images/${layoutConfig.darkTheme.value ? 'logo-white' : 'logo-dark'}.svg`;
});
</script>

<template>
    <div class="layout-footer container">
        <div class="d-none d-lg-flex footerup">
            <img src="/images/logo.svg" alt="airsoftlogo" width="268px">
            <div class="footercontactoyubicacion">
                <h3>Contacto</h3>
                <p> Robert: +34 622 42 13 25</p>
                <p> Germán: +34 616 80 30 96</p>
                <p> Jose (alquileres): +34 611 07 22 55</p>
                <p> dunkerque.airsoft.camp@gmail.com</p>
            </div>
            <div class="footercontactoyubicacion">
                <h3>Ubicación</h3>
                <p> Masia Bach, 08635 Sant Esteve Sesrovires, Barcelona</p>
                <h3>Red social</h3>
                <a class="facebook" href="https://www.facebook.com/p/Dunkerque-Airsoft-Camp-100064113212080/?locale=ca_ES" ><img class="icons" :src="'./images/facebook-green.svg'" alt="" height="45px"></a>
                <a href="https://www.instagram.com/dunkerque.airsoft.camp/" ><img class="icons" :src="'./images/instagram-green.svg'" alt="" height="45px"></a>
            </div>

        </div>
        <div class="footerbottom">
            <p>Dunkerque © {{ new Date().getFullYear() }}. Todos los derechos reservados. <img class="icons" :src="'./images/CIRCULO.svg'" alt="" height="4px">   <router-link to="/">Aviso legal</router-link> | <router-link to="/">Política de privacidad</router-link> |  <router-link to="/">Política de cookies</router-link></p>
        </div>
    </div>
</template>
<style lang="scss" scoped></style>
