import { createRouter, createWebHistory } from "vue-router";
import routes from './routes.js'

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        if (to.hash === '#encontrarnos') {
            return new Promise((resolve) => {
                setTimeout(() => {
                    const el = document.querySelector(to.hash);
                    if (el) {
                        resolve({ el, behavior: 'smooth' });
                    } else {
                        resolve({ top: 0 });
                    }
                }, 100); // Adjust delay as needed
            });
        }
        if (savedPosition) {
            return savedPosition;
        } else {
            return { top: 0 };
        }
    },
})

export default router;
