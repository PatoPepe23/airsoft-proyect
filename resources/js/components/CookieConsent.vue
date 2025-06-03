<template>
    <div v-if="cookieConsentStore.showConsentBanner" class="cookie-consent-banner">
        <div class="consent-content">
            <p>{{ $t('cookie_consent_message') }}</p>
            <div class="consent-buttons">
                <button @click="cookieConsentStore.acceptConsent" class="btn-accept">{{ $t('accept_cookies') }}</button>
                <button @click="cookieConsentStore.rejectConsent" class="btn-reject">{{ $t('reject_cookies') }}</button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { useCookieConsentStore } from '@/store/cookieConsent.js'; // Adjust path if needed

const cookieConsentStore = useCookieConsentStore();

// On component mount, load the initial consent status
onMounted(() => {
    cookieConsentStore.loadConsentStatus();
});
</script>

<style scoped>
/* Your existing CSS for the banner remains the same */
.cookie-consent-banner {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background-color: #333;
    color: white;
    padding: 15px 20px;
    box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.2);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    animation: slideUp 0.5s ease-out forwards;
}

@keyframes slideUp {
    from {
        transform: translateY(100%);
    }
    to {
        transform: translateY(0);
    }
}

.consent-content {
    display: flex;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;
    max-width: 1200px;
    width: 100%;
    justify-content: space-between;
}

.consent-content p {
    margin: 0;
    flex-grow: 1;
    line-height: 1.4;
}

.consent-buttons {
    display: flex;
    gap: 10px;
}

.consent-buttons button {
    padding: 8px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.btn-accept {
    background-color: #28a745; /* Green */
    color: white;
}

.btn-accept:hover {
    background-color: #218838;
}

.btn-reject {
    background-color: #dc3545; /* Red */
    color: white;
}

.btn-reject:hover {
    background-color: #c82333;
}

@media (max-width: 768px) {
    .consent-content {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }
    .consent-buttons {
        flex-direction: column;
        width: 100%;
    }
    .consent-buttons button {
        width: 100%;
    }
}
</style>
