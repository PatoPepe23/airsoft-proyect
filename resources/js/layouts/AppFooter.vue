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
        <div class="footerup">
            <img :src="'./images/logo.svg'" alt="airsoftlogo">
            <div>
                <h3>Contacto</h3>
                <p> Robert: +34 622 42 13 25</p>
                <p> Germán: +34 616 80 30 96</p>
                <p> Jose (alquileres): +34 611 07 22 55</p>
                <p> dunkerque.airsoft.camp@gmail.com</p>
            </div>
            <div>
                <h3>Ubicación</h3>
                <p> Masia Bach, 08635 Sant Esteve Sesrovires, Barcelona</p>
            </div>
            <div>
                <a class="facebook" href="https://www.facebook.com/p/Dunkerque-Airsoft-Camp-100064113212080/?locale=ca_ES" ><img class="icons" :src="'./images/facebook.svg'" alt="" height="35px"></a>
                <a href="https://www.instagram.com/dunkerque.airsoft.camp/" ><img class="icons" :src="'./images/instagram.svg'" alt="" height="35px"></a>
            </div>
        </div>
        <div class="footerbottom">

        </div>
    </div>
</template>
<style lang="scss" scoped></style>
