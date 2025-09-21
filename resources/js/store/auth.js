import axios from 'axios';
import { ref } from "vue";
import { defineStore } from "pinia";

export const authStore = defineStore("authStore", () => {

    let user = ref({});
    let authenticated = ref(false);
    // Nuevo estado para indicar que la verificación de autenticación ha finalizado
    let authReady = ref(false);

    async function login(data) {
        try {
            const response = await axios.get('/api/user');
            user.value = response.data.data;
            authenticated.value = true;
        } catch (error) {
            user.value = {};
            authenticated.value = false;
        } finally {
            // El proceso de autenticación ha terminado
            authReady.value = true;
        }
    }

    async function getUser() {
        try {
            const response = await axios.get('/api/user');
            user.value = response.data.data;
            authenticated.value = true;
            console.log(user.value);
        } catch (error) {
            user.value = {};
            authenticated.value = false;
        } finally {
            // El proceso de autenticación ha terminado
            authReady.value = true;
        }
    }

    function logout() {
        user.value = {};
        authenticated.value = false;
        // Reiniciar el estado
        authReady.value = false;
    }

    return { user, authenticated, authReady, login, getUser, logout};
}, {persist: true});
