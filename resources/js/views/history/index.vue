<template>
    <div class="flex justify-content-center history-father">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/">{{ $t('home') }}</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $t('history') }}</li>
            </ol>
        </nav>
        <div class="container history-container">
            <h1>Historia</h1>
            <div class="history-image-top">
                <img src="/images/historia.jpeg" alt="Soldados aliados esperando en la playa de Dunkerque">
            </div>
            <div class="history-middle">
                <div class="history-text">
                    <h3>La «Operación Dinamo» consistió en la defensa y la evacuación de fuerzas británicas, francesas y belgas por mar en Dunkerque (Francia) entre el 26 de mayo y el 4 de junio de 1940 durante la Segunda Guerra Mundial. Enfrentó al bando aliado y a la Alemania nazi. El choque fue parte de la batalla de Francia del frente occidental.</h3>
                    <h3>La desesperada situación se produjo después de que las fuerzas alemanas rompieran las líneas aliadas durante la batalla de Francia y avanzaran rápidamente hacia la costa atlántica. Este avance envolvió a grandes contingentes de tropas aliadas cerca de Dunkerque. Aislados y bajo el constante ataque de la Wehrmacht, la perspectiva de una rendición masiva parecía inevitable.</h3>
                </div>
                <div class="history-image-middle">
                    <img src="/images/historia_canoa.jpg" alt="Evacuación de Dunkerque en canoa">
                </div>
            </div>
            <div class="history-text-bottom">
                <h3>Sin embargo, la respuesta británica, bajo el mando del almirante Bertram Ramsay, se materializó en la improvisada «Operación Dinamo». Una asombrosa flota, compuesta no solo por destructores y otros buques de la Royal Navy, sino también por cientos de pequeñas embarcaciones civiles —barcos de pesca, yates de recreo, lanchas fluviales y mercantes— zarpó a través del Canal de la Mancha, desafiando el fuego enemigo y las difíciles condiciones marítimas.</h3>
            </div>
        </div>
    </div>
</template>

<script setup>

</script>
