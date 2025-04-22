<template>
    <div class="hyper-nav">
        <nav class="nav navbar navbar-expand-lg justify-content-center fixed w-100">
            <div class="container nav-container">
                <div class="w-100 w-lg-auto position-relative d-lg-block d-flex flex-row-reverse align-items-center justify-content-between">
                    <!-- Botón del toggler -->
                    <router-link to="/" class="nav-logo"><img src="/images/logo.svg" alt="Logo Dunkerque"></router-link>
                    <a class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent">
                        <span class="navbar-toggler-icon"></span>
                    </a>

                    <!-- Menú lateral (offcanvas) -->
                    <div class="d-flex d-lg-none offcanvas offcanvas-start" tabindex="-1" id="navbarSupportedContent" aria-labelledby="offcanvasLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasLabel">Menú</h5>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <ul class="navbar-nav mt-2 mt-lg-0 ms-auto">
                                <li class="nav-item">
                                    <router-link to="/" class="nav-button" aria-current="page">{{ $t('history') }}</router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/booking" class="nav-button">{{ $t('booking') }}</router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="" class="nav-button">{{ $t('rules') }}</router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link to="/" class="nav-button">{{ $t('get_here') }}</router-link>
                                </li>
                                <li v-if="authStore().user && authStore().user.roles && authStore().user.roles[0]?.id == 1" class="nav-item">
                                    <router-link to="/admin" class="nav-button">Administrar</router-link>
                                </li>
                                <LocaleSwitcher class="langSwitcher"/>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="d-none d-lg-flex">
                    <ul class="navbar-nav mt-2 mt-lg-0 ms-auto">
                        <li class="nav-item">
                            <router-link to="/" class="nav-button" aria-current="page">{{ $t('history') }}</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/booking" class="nav-button">{{ $t('booking') }}</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="" class="nav-button">{{ $t('rules') }}</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="" class="nav-button">{{ $t('get_here') }}</router-link>
                        </li>
                        <li v-if="authStore().user && authStore().user.roles && authStore().user.roles[0]?.id == 1" class="nav-item">
                            <router-link to="/admin" class="nav-button">Administrar</router-link>
                        </li>
                    </ul>
                </div>
                <div>
                    <ul class="navbar-nav mt-2 mt-lg-0 ms-auto login-lang-div">
                        <LocaleSwitcher class="langSwitcher"/>
                        <li v-if="!authStore().user?.fullname" class="nav-item">
                            <router-link to="/login" class="nav-button nav-login-button ">{{ $t('login') }}
                            <img src="./../../../public/images/loginHead.svg" alt="" height="24px" class="button-svg">
                            </router-link>
                        </li>
                        <li v-if="authStore().user?.fullname" class="nav-item dropdown">
                            <a class="nav-button nav-login-button" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ authStore().user?.fullname }}
                                <img src="./../../../public/images/loginHead.svg" alt="" height="24px" class="button-svg">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><router-link to="/profile" class="dropdown-item">{{ $t('profile') }}</router-link></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" @click="logout">{{ $t('logout') }}</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</template>

<script setup>
import useAuth from "@/composables/auth";
import LocaleSwitcher from "../components/LocaleSwitcher.vue";
import { authStore } from "../store/auth";
import { useRouter } from 'vue-router';
import { onMounted } from 'vue';

const { processing, logout } = useAuth();
const router = useRouter();
const offcanvasId = 'navbarSupportedContent'; // The ID of your offcanvas div

function closeOffcanvas() {
    const offcanvasElement = document.getElementById(offcanvasId);
    if (offcanvasElement && bootstrap.Offcanvas.getInstance(offcanvasElement)) {
        bootstrap.Offcanvas.getInstance(offcanvasElement).hide();
    }
}

// Close the offcanvas after each route navigation
router.afterEach(() => {
    closeOffcanvas();
});

// Ensure Bootstrap's JavaScript is initialized (if not already)
let bootstrap;
onMounted(() => {
    import('bootstrap').then(b => {
        bootstrap = b;
    });
});
</script>

<style scoped>

@media (min-width: 992px) {
    .w-lg-auto {
        width: auto !important;
    }

}


</style>
