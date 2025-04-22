<template>
    <section id="banner" class="py-10 px-5">
        <h1>{{ $t('webName') }}</h1>
        <h2 class="responsive-title text-center">{{ $t('history_resume') }}</h2>
        <div class="d-flex flex-column">
            <button class="normal-button">{{$t('boton_banner')}}</button>
            <button class="normal-button">{{$t('boton_banner2')}}</button>
        </div>
    </section>
    <section id="sobrenosotros" class="container">

        <div v-html="$t('about_us')" class="sobrenosotros-left"></div>

        <div class="sobrenosotros-right">
            <div class="sobrenosotros-right sobrenosotros-rightseparation">
                <router-link to="/">
                    <div class="caja">
                        <div class="imgcaja"></div>
                        <p>{{ $t('history') }}</p>
                    </div>
                </router-link>

            <router-link to="/" >
                <div class="caja">
                    <div class="imgcaja2"></div>
                    <p>{{ $t('rules') }}</p>
                </div>
            </router-link>
            </div>

            <div class="sobrenosotros-right sobrenosotros-rightseparation">
            <router-link to="/booking" >
                <div class="caja">
                    <div class="imgcaja1"></div>
                    <p>{{ $t('booking') }}</p>
                </div>
            </router-link>

            <a href="#encontrarnos" >
                <div class="caja">
                    <div class="imgcaja3"></div>
                    <p>{{ $t('get_here') }}</p>
                </div>
            </a>
            </div>
        </div>
    </section>
    <section id="tickets">
    <h2>{{ $t('next_games') }}</h2>
        <div class="ticketbody container" >
            <div class="ticketcaja">
                <div class="ticketconboton">
                    <div class="ticket cutout-image">
                        <div>
                            <p>Sábado 1 de Febrero</p>
                            <p>{{$t('ticket_text2')}}</p>
                        </div>
                    </div>
                    <router-link to="/" class="ticketbutton cutout-image1"><p>></p></router-link>
                </div>
                <div class="ticketconboton">
                    <div class="ticket cutout-image">
                        <div>
                            <p>Sábado 1 de Febrero</p>
                            <p>{{$t('ticket_text2')}}</p>
                        </div>
                    </div>
                    <router-link to="/" class="ticketbutton cutout-image1"><p>></p></router-link>
                </div>
            </div>
            <div class="ticketcaja">
                <div class="ticketconboton">
                    <div class="ticket cutout-image">
                        <div>
                            <p>Sábado 1 de Febrero</p>
                            <p>{{$t('ticket_text2')}}</p>
                        </div>
                    </div>
                    <router-link to="/" class="ticketbutton cutout-image1"><p>></p></router-link>
                </div>
                <div class="ticketconboton">
                    <div class="ticket cutout-image">
                        <div>
                            <p>Sábado 1 de Febrero</p>
                            <p>{{$t('ticket_text2')}}</p>
                        </div>
                    </div>
                    <router-link to="/" class="ticketbutton cutout-image1"><p>></p></router-link>
                </div>

            </div>

        </div>
    </section>
    <section id="encontrarnos" class="container">
        <h2>{{ $t('find_us') }}</h2>
        <div class="mapsiconoscaja">
            <div class="mapsiconos"><a href="https://maps.app.goo.gl/UJEW8JCeMrCVRszE8" target="_blank" ><img :src="'./images/googlemaps.svg'" alt="" height="40px"></a><a href="https://ul.waze.com/ul?place=ChIJbe--d3uJpBIRzkCD3RVVFok&ll=41.48944500%2C1.85023020&navigate=yes&utm_campaign=default&utm_source=waze_website&utm_medium=lm_share_location" target="_blank"  ><img :src="'./images/waze.svg'" alt="" height="40px"></a></div>
        </div>
        <div class="maps">
            <div class="contactos">
                <div>
                    <h3><u>{{ $t('contacts') }}</u></h3>
                    <p><img :src="'./images/telefono.svg'" alt="" height="24px"> Robert: +34 622 42 13 25</p>
                    <p><img :src="'./images/telefono.svg'" alt="" height="24px"> Germán: +34 616 80 30 96</p>
                    <p><img :src="'./images/telefono.svg'" alt="" height="24px"> Jose (alquileres): +34 611 07 22 55</p>
                    <p><img :src="'./images/ubicacion.svg'" alt="" height="28px"> Masia Bach, 08635 Sant Esteve Sesrovires, Barcelona</p>
                    <p><img :src="'./images/email.svg'" alt="" height="24px"> dunkerque.airsoft.camp@gmail.com</p>
                    <a class="facebook" href="https://www.facebook.com/p/Dunkerque-Airsoft-Camp-100064113212080/?locale=ca_ES" ><img :src="'./images/facebook.svg'" alt="" height="35px"></a>
                    <a href="https://www.instagram.com/dunkerque.airsoft.camp/" ><img :src="'./images/instagram.svg'" alt="" height="35px"></a>
                </div>
            </div>
            <iframe class="hidden md:block" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d2186.6496725878847!2d1.8500931773698173!3d41.48928309397323!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a4897b77beef6d%3A0x89165515dd8340ce!2sDunkerque%20Airsoft%20Camp!5e1!3m2!1ses!2ses!4v1739816091320!5m2!1ses!2ses" width="800" height="600" style="border:0;" allowfullscreen="false" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>
    <section id="colaboradores">
    <h2>{{ $t('collaborators') }}</h2>
        <div class="carousel container">
            <div class="group">
                <div class="carrouCard"><img :src="'./images/BarElCasino.png'" alt="barCasino"></div>
                <div class="carrouCard"><img :src="'./images/barnaAirsoft.png'" alt="barnaAirsoft"></div>
                <div class="carrouCard"><img :src="'./images/DisMatac.png'" alt="disMatac"></div>
                <div class="carrouCard"><img :src="'./images/hobbyRace.png'" alt="hobbyRace"></div>
                <div class="carrouCard"><img :src="'./images/SDJairsoft.png'" alt="sdjAirsoft"></div>
                <div class="carrouCard"><img :src="'./images/TheTacticalCave.png'" alt="theTacticalCave"></div>
            </div>

            <div class="group">
                <div class="carrouCard"><img :src="'./images/BarElCasino.png'" alt="barCasino"></div>
                <div class="carrouCard"><img :src="'./images/barnaAirsoft.png'" alt="barnaAirsoft"></div>
                <div class="carrouCard"><img :src="'./images/DisMatac.png'" alt="disMatac"></div>
                <div class="carrouCard"><img :src="'./images/hobbyRace.png'" alt="hobbyRace"></div>
                <div class="carrouCard"><img :src="'./images/SDJairsoft.png'" alt="sdjAirsoft"></div>
                <div class="carrouCard"><img :src="'./images/TheTacticalCave.png'" alt="theTacticalCave"></div>
            </div>
        </div>
    </section>
</template>
<script setup lang="ts">

import { langStore } from "@/store/lang";

const storedLang = langStore().locale;

</script>
