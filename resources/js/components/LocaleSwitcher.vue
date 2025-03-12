<template>

    <li v-if="Object.keys(locales).length > 1" class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button"
           data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
        >
            {{ locales[locale] }}
        </a>
        <div class="dropdown-menu">
            <a v-for="(value, key) in langStore().locales" :key="key" class="dropdown-item" href="#"
               @click.prevent="setLocale(key)"
            >
                {{ value }}
            </a>
        </div>
    </li>
</template>
<!--<template>
    <div>
        <select
        v-model="currentLocale"
        :options="languages"
        optionLabel="name"
        optionValue="code"
        @update:modelValue="changeLanguage"
        class="p-inputtext-sm"
        >
            <template #value="{ value }">
                <div class="flex items-center gap-2">
                    <span class="pl-8">{{ getLanguageName(value) }}</span>
                </div>
            </template>
        </select>
    </div>
</template>-->

<script setup>
import {computed} from "vue";
import { langStore } from "@/store/lang";
import { useI18n } from 'vue-i18n'
import { loadMessages } from '@/plugins/i18n';


const i18n = useI18n({useScope: "global"});

const locale = computed(() => langStore().locale)
const locales = computed(() => langStore().locales)

function setLocale(locale) {
    if (i18n.locale !== locale) {
        langStore().setLocale(locale);
    }
}

/*const storedLang = langStore().locale;
const currentLocale = ref(storedLang);

const languages = ref([
    { name: "Català", code: "ca" },
    { name: "Español", code: "es" },
    { name: "English", code: "en" }
]);

const getLanguageName = (code) => {
    return languages.value.find((lang) => lang.code === code)?.name || "Unknown";
};

// Handle language change
const changeLanguage = (newLang) => {
    if (langStore().locale !== newLang) {
        langStore().setLocale(newLang);
        window.location.reload();
    }
}*/

</script>

<style scoped>

</style>
