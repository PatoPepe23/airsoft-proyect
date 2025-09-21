<template>
    <div class="container flex">
        <div class="nav-avoid">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><router-link to="/">{{ $t('home') }}</router-link></li>
                    <li class="breadcrumb-item active" aria-current="page">Privacy & Politics</li>
                </ol>
            </nav>
        </div>
        <div class="flex">
                <div class="container rules-container">

                    <div class="rules-page">
                        <h1>Política de Privacidad</h1>

                        <section class="rules-section">
                            <h2>1. Introducción</h2>
                            <p>
                                En <strong>Dunkerque</strong> valoramos y respetamos tu privacidad.
                                Esta política explica cómo recopilamos, usamos y protegemos tu información personal.
                            </p>
                        </section>

                        <section class="rules-section">
                            <h2>2. Información que recopilamos</h2>
                            <ul class="rules-list">
                                <li>Datos de registro: nombre completo, DNI, correo electrónico, teléfono.</li>
                                <li>Información de reservas: partidas y pedidos asociados.</li>
                                <li>Datos técnicos: dirección IP, navegador y actividad en nuestra web.</li>
                            </ul>
                        </section>

                        <section class="rules-section">
                            <h2>3. Uso de la información</h2>
                            <p>Utilizamos la información recopilada para:</p>
                            <ol class="rules-list numbered">
                                <li>Gestionar reservas y pedidos.</li>
                                <li>Mejorar la experiencia de usuario.</li>
                                <li>Cumplir con obligaciones legales.</li>
                                <li>Comunicarnos contigo sobre cambios en las partidas o servicios.</li>
                            </ol>
                        </section>

                        <section class="rules-section">
                            <h2>4. Protección de datos</h2>
                            <p>
                                Implementamos medidas de seguridad físicas y digitales para proteger tu información
                                contra accesos no autorizados, alteraciones o divulgación indebida.
                            </p>
                        </section>

                        <section class="rules-section">
                            <h2>5. Compartición de información</h2>
                            <p>
                                No compartimos tus datos personales con terceros, salvo en los siguientes casos:
                            </p>
                            <ul class="rules-list">
                                <li>Cuando sea requerido por la ley o una autoridad competente.</li>
                                <li>Con proveedores de servicios que nos ayudan en la gestión de reservas.</li>
                            </ul>
                        </section>

                        <section class="rules-section">
                            <h2>6. Derechos del usuario</h2>
                            <p>Tienes derecho a:</p>
                            <ul class="rules-list">
                                <li>Acceder, rectificar o eliminar tus datos personales.</li>
                                <li>Oponerte al tratamiento de tus datos.</li>
                                <li>Solicitar la portabilidad de tu información.</li>
                            </ul>
                            <p class="important-note">
                                Para ejercer tus derechos, puedes escribirnos a:
                                <a href="mailto:dunkerque.airsoft.camp@gmail.com">dunkerque.airsoft.camp@gmail.com</a>
                            </p>
                        </section>

                        <section class="rules-section">
                            <h2>7. Cambios en esta política</h2>
                            <p>
                                Nos reservamos el derecho de actualizar esta política en cualquier momento.
                                Te recomendamos revisarla periódicamente.
                            </p>
                        </section>

                        <section class="rules-section">
                            <h2>8. Contacto</h2>
                            <p>
                                Si tienes dudas sobre esta política de privacidad, puedes contactarnos en:
                                <br>
                                <strong>Email:</strong> dunkerque.airsoft.camp@gmail.com
                                <br>
                                <!--<strong>Teléfono:</strong> +34 600 123 456 -->
                            </p>
                        </section>
                    </div>
                </div>


        </div>

    </div>
</template>

<script setup>
import axios from 'axios';
import {ref, onMounted} from 'vue';

const posts = ref();

onMounted(() => {
    axios.get('/api/get-posts').then(({data}) => {
        posts.value = data;
    })
})

</script>
<style scoped>
.rules-container {
    margin-top: 20px;
}
.rules-page h1 {
    margin-bottom: 20px;
    color: #283227;
}
.rules-section {
    margin-bottom: 25px;
}
.rules-section h2 {
    margin-bottom: 10px;
    color: #283227;
}
.rules-list {
    margin-left: 20px;
}
.numbered {
    list-style-type: decimal;
}
.important-note {
    margin-top: 10px;
    font-weight: bold;
    color: #b30000;
}
</style>
