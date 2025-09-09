<template>
    <div class="hyper-nav">
        <nav class="nav navbar navbar-expand-lg justify-content-center fixed w-100">
            <div class="container nav-container">
                <div class="w-100 w-lg-auto position-relative d-lg-block d-flex flex-row-reverse align-items-center justify-content-between">
                    <router-link to="/" class="nav-logo">
                        <img src="/images/logo.svg" alt="Logo Dunkerque">
                    </router-link>
                    <a class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent">
                        <span class="navbar-toggler-icon"></span>
                    </a>

                    <div class="d-flex d-lg-none offcanvas offcanvas-start" tabindex="-1" id="navbarSupportedContent" aria-labelledby="offcanvasLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasLabel">Menú</h5>
<!--                            <LocaleSwitcher class="langSwitcher"/>-->
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <ul class="navbar-nav mt-2 mt-lg-0 ms-auto">
                                <li v-for="item in filteredMenu" :key="item.label" class="nav-item">
                                    <router-link v-if="item.to" :to="item.to" class="nav-button">{{ $t(item.label) }}</router-link>

                                    <a v-else-if="item.action" href="#" class="nav-button" @click.prevent="item.actionMobile">{{ $t(item.label) }}</a>
                                </li>
                            </ul>
                            <ul class="navbar-nav mt-2 mt-lg-0 ms-auto m-0 login-lang-div">
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
                                        <li v-if="authStore().hasAdminAccess"><router-link to="/admin/posts" class="dropdown-item">Administrar</router-link></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="d-none d-lg-flex">
                    <ul class="navbar-nav mt-2 mt-lg-0 ms-auto">
                        <li v-for="item in filteredMenu" :key="item.label" class="nav-item">
                            <router-link v-if="item.to" :to="item.to" class="nav-button">{{ $t(item.label) }}</router-link>

                            <a v-else-if="item.action" href="#" class="nav-button" @click.prevent="item.action">{{ $t(item.label) }}</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <ul class=" d-none d-lg-flex navbar-nav mt-2 mt-lg-0 ms-auto login-lang-div">
<!--                        <LocaleSwitcher class="langSwitcher"/>-->
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
                                <li v-if="authStore().hasAdminAccess"><router-link to="/admin/posts" class="dropdown-item">Administrar</router-link></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRouter } from 'vue-router';
import useAuth from "@/composables/auth";
import LocaleSwitcher from "../components/LocaleSwitcher.vue";
import { authStore } from "../store/auth";
import { useI18n } from 'vue-i18n';

const { logout } = useAuth();
const router = useRouter();
const offcanvasId = 'navbarSupportedContent';

const { t } = useI18n();

// Define the menu structure with permissions
// The 'label' property should match the keys in your i18n file (e.g., 'history', 'booking')
const menuItems = computed(() => {
    return [
        { label: 'history', to: '/history', permission: 'all' },
        { label: 'booking', to: '/booking', permission: 'all' },
        { label: 'rules', to: '/rules', permission: 'all' },
        { label: 'get_here', action: getHere, actionMobile: getHereMobile,  permission: 'all', scroll: true, scrollY: 2800 },
        { label: 'Administrar', to: '/admin/posts', permission: 'post-list' },
    ];
});

// A computed property to filter the menu based on permissions
const filteredMenu = computed(() => {
    const userPermissions = authStore().user?.permissions || [];
    const userRoleId = authStore().user?.roles?.[0]?.id; // Get the user's main role ID

    return menuItems.value.filter(item => {
        // If the permission is 'all', it's always visible
        if (item.permission === 'all') {
            return true;
        }

        // Check for specific roles
        if (item.permission === 'admin' && (userRoleId === 1 || userRoleId === 2)) {
            return true;
        }

        if (item.permission === 'post-list' && (userRoleId === 1 || userRoleId === 2)) {
            return true;
        }


        // If the item requires a specific permission, check if the user has it
        return userPermissions.includes(item.permission);
    });
});

const getHereMobile = () => {
    router.push({ name: 'home' }).then(() => {
        window.scrollTo(0, 4600);
    });
};

const getHere = () => {
    router.push({ name: 'home' }).then(() => {
        window.scrollTo(0, 2800);
    });
};

function closeOffcanvas() {
    const offcanvasElement = document.getElementById(offcanvasId);
    if (offcanvasElement && bootstrap.Offcanvas.getInstance(offcanvasElement)) {
        bootstrap.Offcanvas.getInstance(offcanvasElement).hide();
    }
}

router.afterEach(() => {
    closeOffcanvas();
});

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
