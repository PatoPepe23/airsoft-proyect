// stores/cookieConsent.js
import { defineStore } from 'pinia';
import Cookies from 'js-cookie';

// Define cookie names and options for consent
const CONSENT_COOKIE_NAME = 'user_cookie_consent';
const CONSENT_OPTIONS = { expires: 365, sameSite: 'Lax', secure: true }; // Expires in 1 year

// Define your non-essential cookies to clear if consent is revoked
const NON_ESSENTIAL_COOKIE_PREFIX = 'airsoft_booking_';
const NON_ESSENTIAL_COOKIE_NAMES = [
    NON_ESSENTIAL_COOKIE_PREFIX + 'DNI',
    NON_ESSENTIAL_COOKIE_PREFIX + 'nombrecompleto',
    NON_ESSENTIAL_COOKIE_PREFIX + 'email',
    NON_ESSENTIAL_COOKIE_PREFIX + 'telefono',
    NON_ESSENTIAL_COOKIE_PREFIX + 'alquiler',
    NON_ESSENTIAL_COOKIE_PREFIX + 'team',
];


export const useCookieConsentStore = defineStore('cookieConsent', {
    state: () => ({
        showConsentBanner: false,
        hasConsentForPreferences: false,
    }),

    actions: {
        // Loads the initial consent status from the cookie
        loadConsentStatus() {
            const consent = Cookies.get(CONSENT_COOKIE_NAME);
            if (consent === 'accepted') {
                this.hasConsentForPreferences = true;
                this.showConsentBanner = false;
            } else if (consent === 'rejected') {
                this.hasConsentForPreferences = false;
                this.showConsentBanner = false;
            } else {
                // No consent cookie found, so show the banner
                this.showConsentBanner = true;
            }
        },

        // Action when user accepts cookies
        acceptConsent() {
            Cookies.set(CONSENT_COOKIE_NAME, 'accepted', CONSENT_OPTIONS);
            this.hasConsentForPreferences = true;
            this.showConsentBanner = false;
            console.log('Consent accepted. Preferences cookies can now be used.');
        },

        rejectConsent() {
            Cookies.set(CONSENT_COOKIE_NAME, 'rejected', CONSENT_OPTIONS);
            this.hasConsentForPreferences = false;
            this.showConsentBanner = false;
            console.log('Consent rejected. Clearing non-essential cookies.');
            this.clearNonEssentialCookies();
        },

        resetConsent() {
            console.log('Resetting cookie consent...');
            Cookies.remove(CONSENT_COOKIE_NAME);
            this.clearNonEssentialCookies();
            this.showConsentBanner = true;
            this.hasConsentForPreferences = false;
            console.log('Cookie consent reset. Banner should reappear.');
        },

        clearNonEssentialCookies() {
            NON_ESSENTIAL_COOKIE_NAMES.forEach(cookieName => {
                Cookies.remove(cookieName);
            });
            console.log('Non-essential cookies cleared.');
        }
    },
});
