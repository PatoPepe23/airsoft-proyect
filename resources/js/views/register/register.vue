<template>
    <div class="login-body">
        <div class="row justify-content-center my-5">
            <div class="col-md-6 center-login-div">
                <div class="card border-0 shadow-sm register-container">
                  <div class="login-register-selector">
                    <router-link to="/login" class="login-button" aria-current="page">{{ $t('login') }}</router-link>
                    <router-link to="/" class="login-logo"><img :src="'./images/logo.svg'" alt=""></router-link>
                    <router-link to="" class="login-button" active-class="button-activated" aria-current="page">{{ $t('register') }}</router-link>
                  </div>
                    <div class="card-body">
                        <form @submit.prevent="submitRegister">
                            <div class="register-div">
                                <div>
                                  <!-- Full Name -->
                                  <div class="mb-3">
                                      <label for="name" class="form-label">{{ $t('fullName') }}</label>
                                      <input v-model="registerForm.fullName" id="name" type="text" class="form-control" autofocus>
                                      <!-- Validation Errors -->
                                      <div class="text-danger mt-1">
                                          <div v-for="message in validationErrors?.name">
                                              {{ message }}
                                          </div>
                                      </div>
                                  </div>
                                  <!-- DNI -->
                                  <div class="mb-3">
                                      <label for="email" class="form-label">DNI</label>
                                      <input v-model="registerForm.DNI" id="DNI" type="text" class="form-control" autocomplete="DNI">
                                      <!-- Validation Errors -->
                                      <div class="text-danger mt-1">
                                          <div v-for="message in validationErrors?.DNI">
                                              {{ message }}
                                          </div>
                                      </div>
                                  </div>
                                  <div class="mb-3">
                                      <label for="email" class="form-label">{{ $t('email') }}</label>
                                      <input v-model="registerForm.email" id="email" type="email" class="form-control" autocomplete="email">
                                      <!-- Validation Errors -->
                                      <div class="text-danger mt-1">
                                          <div v-for="message in validationErrors?.email">
                                              {{ message }}
                                          </div>
                                      </div>
                                  </div>
                                </div>
                                <div>
                                  <!-- Phone Number -->
                                  <div class="mb-3">
                                      <label for="email" class="form-label">{{ $t('number') }}</label>
                                      <input v-model="registerForm.number" id="number" type="number" class="form-control" autocomplete="tel-national">
                                      <!-- Validation Errors -->
                                      <div class="text-danger mt-1">
                                          <div v-for="message in validationErrors?.number">
                                              {{ message }}
                                          </div>
                                      </div>
                                  </div>
                                  <!-- Password -->
                                  <div class="mb-3">
                                      <label for="password" class="form-label">
                                          {{ $t('password') }}
                                      </label>
                                      <input v-model="registerForm.password" id="password" type="password" class="form-control" autocomplete="current-password">
                                      <!-- Validation Errors -->
                                      <div class="text-danger-600 mt-1">
                                          <div v-for="message in validationErrors?.password">
                                              {{ message }}
                                          </div>
                                      </div>
                                  </div>
                                  <div class="mb-3">
                                      <label for="password_confirmation" class="form-label">
                                          {{ $t('confirm_password') }}
                                      </label>
                                      <input v-model="registerForm.password_confirmation" id="password_confirmation" type="password" class="form-control" autocomplete="current-password">
                                      <!-- Validation Errors -->
                                      <div class="text-danger-600 mt-1">
                                          <div v-for="message in validationErrors?.password_confirmation">
                                              {{ message }}
                                          </div>
                                      </div>
                                  </div>
                                </div>

                                <!-- Buttons -->
                              <div class="register-buttons">
                                <div class="register-checkboxes">
                                  <div>
                                    <input class="form-check-input" type="checkbox" name="termsConditions" id="termsAndConditions">
                                    <label class="form-check-label" for="termsAndConditions">
                                      {{ $t('terms_and_conditions') }}
                                    </label>
                                  </div>
                                  <div>
                                    <input class="form-check-input" type="checkbox" name="sendMails" id="sendMails">
                                    <label class="form-check-label" for="sendMails">
                                      {{ $t('sendMails') }}
                                    </label>
                                  </div>
                                </div>
                                <div class="flex items-center justify-end mt-4">
                                    <button class="normal-button submit-login-button" :class="{ 'opacity-25': processing }" :disabled="processing">
                                        {{ $t('register') }}
                                    </button>
                                </div>
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

const { registerForm, validationErrors, processing, submitRegister} = useAuth();

</script>
