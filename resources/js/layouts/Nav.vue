<template>
    <div class="hyper-nav">
        <nav class="nav navbar navbar-expand-lg justify-content-center fixed w-100">
            <div class="container nav-container">
                <div>
                    <router-link to="/" class="nav-logo"><img :src="'./images/logo.svg'" alt=""></router-link>
                    <a class="navbar-toggler" type="button" data-bs-toggle  ="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </a>
                </div>
                <div>
                    <ul class="navbar-nav mt-2 mt-lg-0 ms-auto">
                        <li class="nav-item">
                            <router-link to="/" class="nav-button" aria-current="page">Historia</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{ name : 'public-posts.index'}" class="nav-button">Reserva</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="" class="nav-button">Normativa</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="" class="nav-button">Como llegar</router-link>
                        </li>
                        <li v-if="authStore().user?.name" class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ authStore().user?.name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><router-link class="dropdown-item" to="/admin">Admin</router-link></li>
                                <li><router-link to="/admin/posts" class="dropdown-item">Post</router-link></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="javascript:void(0)" @click="logout">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <template v-if="!authStore().user?.name">
                    <div>
                        <ul class="navbar-nav mt-2 mt-lg-0 ms-auto">
                            <li class="nav-item">
                                <router-link to="login" class="nav-button ">Login
                                <img src="./../../../public/images/loginHead.svg" alt="" height="24px" class="button-svg">
                                </router-link>
                            </li>

                        </ul>
                    </div>
                </template>
            </div>
        </nav>
    </div>
</template>

<script setup>

import useAuth from "@/composables/auth";
import LocaleSwitcher from "../components/LocaleSwitcher.vue";
import { authStore } from "../store/auth";

const { processing, logout } = useAuth();
</script>
