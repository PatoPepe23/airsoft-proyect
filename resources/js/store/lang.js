import {reactive, ref} from "vue";
import { defineStore } from "pinia";

export const
    langStore = defineStore("langStore", () => {

    let locale = ref(window.config.locale);
    let locales = ref(window.config.locales);

    console.log(window.config);

    function setLocale(l) {
        locale.value = l;
    }

    return { locale, locales, setLocale};
}, {persist: true});
