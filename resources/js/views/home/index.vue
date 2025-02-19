<template>
    <section id="banner">
        <h1>DUNKERQUE AIRSOFT CAMP</h1>
        <h2>La «Operación Dinamo» consistió en la defensa y la evacuación de fuerzas británicas, francesas y belgas por mar en Dunkerque (Francia).</h2>
        <div>
            <button class="normal-button">Reservar partida publica Sabado 1</button>
            <button class="normal-button">Reservar partida publica Domingo 2</button>
        </div>
    </section>
    <section id="sobrenosotros" class="container">
        <div class="sobrenosotros-left">
            <h2>Sobre nosotros</h2>
            <h3>Dunkerque, campo destinado a la practica de airsoft.</h3>
            <p>En <strong>Dunkerque</strong> se lleva a cabo todo tipo de eventos tácticos: simulación militar, policial, recreación histórica, etc. gestionado por C.T.A. AIRSOFT CAMP.</p>

            <p><strong>Asociación C.T.A. (Centro táctico de actividades)</strong> quiere ofrecer un escenario distinto con pinceladas de realismo para que podáis meteros en la piel de cualquier soldado del Eje o aliado.</p>
        </div>
        <div class="sobrenosotros-right">
            <div class="sobrenosotros-right">
                <router-link to="/">
                    <div class="caja">
                        <div class="imgcaja"></div>
                        <p>Historia</p>
                    </div>
                </router-link>

            <router-link to="/" >
                <div class="caja">
                    <div class="imgcaja2"></div>
                    <p>Normativa</p>
                </div>
            </router-link>
            </div>

            <div class="sobrenosotros-right">
            <router-link to="/" >
                <div class="caja">
                    <div class="imgcaja1"></div>
                    <p>Reservas</p>
                </div>
            </router-link>

            <router-link to="/" >
                <div class="caja">
                    <div class="imgcaja3"></div>
                    <p>Como llegar</p>
                </div>
            </router-link>
            </div>
        </div>
    </section>
    <section id="tickets">
    <h2>Proximas partidas</h2>
        <div class="ticketbody container" >
            <div class="ticketcaja">
                <div class="ticketconboton">
                    <div class="ticket cutout-image">
                        <div>
                            <p>Sábado 1 de Febrero</p>
                            <p>Partida pública</p>
                        </div>
                        <p>8h - 13h</p>
                    </div>
                    <router-link to="/" class="ticketbutton cutout-image1"><p>></p></router-link>
                </div>
                <div class="ticketconboton">
                    <div class="ticket cutout-image">
                        <div>
                            <p>Sábado 1 de Febrero</p>
                            <p>Partida pública</p>
                        </div>
                        <p>8h - 13h</p>
                    </div>
                    <router-link to="/" class="ticketbutton cutout-image1"><p>></p></router-link>
                </div>
            </div>
            <div class="ticketcaja">
                <div class="ticketconboton">
                    <div class="ticket cutout-image">
                        <div>
                            <p>Sábado 1 de Febrero</p>
                            <p>Partida pública</p>
                        </div>
                        <p>8h - 13h</p>
                    </div>
                    <router-link to="/" class="ticketbutton cutout-image1"><p>></p></router-link>
                </div>
                <div class="ticketconboton">
                    <div class="ticket cutout-image">
                        <div>
                            <p>Sábado 1 de Febrero</p>
                            <p>Partida pública</p>
                        </div>
                        <p>8h - 13h</p>
                    </div>
                    <router-link to="/" class="ticketbutton cutout-image1"><p>></p></router-link>
                </div>

            </div>

        </div>
    </section>
    <section id="encontrarnos" class="container">
        <h2>Como encontrarnos</h2>
        <div class="mapsiconoscaja">
            <div class="mapsiconos"><a href="https://maps.app.goo.gl/UJEW8JCeMrCVRszE8" target="_blank" ><img :src="'./images/googlemaps.svg'" alt="" height="40px"></a><a href="https://ul.waze.com/ul?place=ChIJbe--d3uJpBIRzkCD3RVVFok&ll=41.48944500%2C1.85023020&navigate=yes&utm_campaign=default&utm_source=waze_website&utm_medium=lm_share_location" target="_blank"  ><img :src="'./images/waze.svg'" alt="" height="40px"></a></div>
        </div>
        <div class="maps">
            <div class="contactos">
                <div>
                    <h3><u>Nuestros contactos</u></h3>
                    <p><img :src="'./images/telefono.svg'" alt="" height="24px"> Robert: +34 622 42 13 25</p>
                    <p><img :src="'./images/telefono.svg'" alt="" height="24px"> Germán: +34 616 80 30 96</p>
                    <p><img :src="'./images/telefono.svg'" alt="" height="24px"> Jose (alquileres): +34 611 07 22 55</p>
                    <p><img :src="'./images/ubicacion.svg'" alt="" height="28px"> Masia Bach, 08635 Sant Esteve Sesrovires, Barcelona</p>
                    <p><img :src="'./images/email.svg'" alt="" height="24px"> dunkerque.airsoft.camp@gmail.com</p>
                    <a class="facebook" href="https://www.facebook.com/p/Dunkerque-Airsoft-Camp-100064113212080/?locale=ca_ES" ><img :src="'./images/facebook.svg'" alt="" height="35px"></a>
                    <a href="https://www.instagram.com/dunkerque.airsoft.camp/" ><img :src="'./images/instagram.svg'" alt="" height="35px"></a>
                </div>
            </div>
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d2186.6496725878847!2d1.8500931773698173!3d41.48928309397323!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a4897b77beef6d%3A0x89165515dd8340ce!2sDunkerque%20Airsoft%20Camp!5e1!3m2!1ses!2ses!4v1739816091320!5m2!1ses!2ses" width="800" height="600" style="border:0;" allowfullscreen="false" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>
    <section id="colaboradores">
    <h2>Colaboradores</h2>

    </section>
</template>
<script setup lang="ts">

</script>
