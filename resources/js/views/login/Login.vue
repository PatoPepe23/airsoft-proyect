<template>
    <div class="login-body">
        <div class="row justify-content-center my-5">
            <div class="col-md-6 center-login-div">
                <div class="card border-0 shadow-sm login-container">
                    <div class="login-register-selector">
                        <router-link to="" class="login-button" active-class="button-activated" aria-current="page">{{ $t('login') }}</router-link>
                        <router-link to="/" class="login-logo"><img :src="'./images/logo.svg'" alt=""></router-link>
                        <router-link to="/register" class="login-button" aria-current="page">{{ $t('register') }}</router-link>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="submitLogin">
                            <div class="">
                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">{{ $t('email')  }}</label>
                                    <input v-model="loginForm.email" id="email" type="email" class="form-control" required autofocus autocomplete="username">
                                    <!-- Validation Errors -->
                                    <div class="text-danger mt-1">
                                        <div v-for="message in validationErrors?.email">
                                            {{ message }}
                                        </div>
                                    </div>
                                </div>
                                <!-- Password -->
                                <div class="mb-4">
                                    <label for="password" class="form-label">
                                        {{ $t('password') }}
                                    </label>
                                    <input v-model="loginForm.password" id="password" type="password" class="form-control" required autocomplete="current-password">
                                    <!-- Validation Errors -->
                                    <div class="text-danger-600 mt-1">
                                        <div v-for="message in validationErrors?.password">
                                            {{ message }}
                                        </div>
                                    </div>
                                    <router-link class="forgot-password" :to="{name: 'auth.forgot-password'}">{{ $t('forgot_password')}}</router-link>
                                </div>

                                <!-- Remember me -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" v-model="loginForm.remember" id="flexCheckIndeterminate">
                                    <label class="form-check-label" for="flexCheckIndeterminate">
                                        {{ $t('remember_me') }}
                                    </label>
                                </div>

                                <!-- Buttons -->
                                <div class="flex items-center justify-content-center mt-4">
                                    <button class="normal-button submit-login-button" :class="{ 'opacity-25': processing }" :disabled="processing">
                                        {{ $t('login') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

import useAuth from '@/composables/auth'

const { loginForm, registerForm, validationErrors, processing, submitLogin } = useAuth();

</script>
