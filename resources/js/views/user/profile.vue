<template>
    <div class="container profile-container">
        <div class="grid justify-content-center">
            <div class="col-12 md:col-8 lg:col-8 xl:col-8">
                <div class="card mb-3 profile-info-container">
                    <h6 class="mb-2 text-primary">{{ $t('personal_details') }}</h6>

                    <div class="form-group">
                        <label for="name">{{ $t('fullName') }}</label>
                        <input v-model="user.fullname" type="text" class="form-control" id="name">
                        <div class="text-danger mt-1">
                            <div v-for="message in validationErrors?.fullname">
                                {{ message }}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="surname1">DNI</label>
                        <input v-model="user.DNI" type="text" class="form-control" id="surname1">
                        <div class="text-danger mt-1">
                            <div v-for="message in validationErrors?.DNI">
                                {{ message }}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="surname2">{{ $t('number') }}</label>
                        <input v-model="user.phonenumber" type="text" class="form-control" id="surname2">
                        <div class="text-danger mt-1">
                            <div v-for="message in validationErrors?.phonenumber">
                                {{ message }}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">{{ $t('email') }}</label>
                        <input v-model="user.email" type="email" class="form-control" id="email">
                        <div class="text-danger mt-1">
                            <div v-for="message in validationErrors?.email">
                                {{ message }}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">{{ $t('password') }}</label>
                        <input v-model="user.password" type="password" class="form-control" id="password" placeholder="********">
                        <div class="text-danger mt-1">
                            <div v-for="message in validationErrors?.password">
                                {{ message }}
                            </div>
                        </div>
                    </div>

                    <div class="text-right">
                        <button :disabled="isLoading" class="btn btn-primary w-100" @click="submitForm">
                            <div v-show="isLoading" class=""></div>
                            <span v-if="isLoading">{{ $t('processing') }}...</span>
                            <span v-else>{{ $t('save') }}</span>
                        </button>
                    </div>
                    <div class="flex flex-row-reverse justify-content-between align-items-end">
                        <router-link class="delete-account-button" to="/">Elminiar cuenta</router-link>
                        <div class="data-infor">
                            <p>*Tus datos se utilizaran para autocompletar tus reservas.</p>
                            <p>*Manten tus datos actualizados.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import useUsers from "@/composables/users.js";
import { reactive, onMounted, watchEffect } from "vue";
import { useRoute } from "vue-router";
import { useForm, useField, defineRule } from "vee-validate";
import { required, min } from "@/validation/rules";
import useAuth from '@/composables/auth'

defineRule('required', required);
defineRule('min', min);

const { updateUser, getUser, user: postData, validationErrors, isLoading } = useUsers();
const { user: loggedUser } = useAuth();
const route = useRoute();

// Define a validation schema
const schema = {
    fullname: 'required',
    email: 'required',
    DNI: 'required',
    phonenumber: 'required',
    password: 'min:8'
};

// Create a form context with the validation schema
const { validate, errors, resetForm } = useForm({ validationSchema: schema });

// Define actual fields for validation
const { value: fullname } = useField('fullname', null, { initialValue: '' });
const { value: email } = useField('email', null, { initialValue: '' });
const { value: DNI } = useField('DNI', null, { initialValue: '' });
const { value: phonenumber } = useField('phonenumber', null, { initialValue: '' });
const { value: password } = useField('password', null, { initialValue: '' });

const user = reactive({
    id: null,
    fullname,
    email,
    DNI,
    phonenumber,
    password,
});

function submitForm() {

    validate().then(form => {
        if (form.valid) {
            updateUser(user);
        }
    });
}

onMounted(async () => {
    getUser(route.params.id);
});

watchEffect(() => {
    if (postData.value) {
        user.id = loggedUser.id;
        user.fullname = loggedUser.fullname;
        user.email = loggedUser.email;
        user.DNI = loggedUser.DNI;
        user.phonenumber = loggedUser.phonenumber;
        user.password = loggedUser.password; // Make sure this is intended
        user.role_id = loggedUser.role_id;
    }
});



</script>

<style scoped>

</style>
