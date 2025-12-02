import { createWebHistory, createRouter } from "vue-router";

import Home from '../pages/Home';
import Dashboard from '../pages/Dashboard';
import Reviews from '../components/Reviews';

export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'dashboard',
        path: '/dashboard',
        component: Dashboard
    },
    {
        name: 'reviews',
        path: '/reviews',
        component: Articles
    },


];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});


router.beforeEach((to, from, next) => {
    const token = localStorage.getItem("token");
    if (to.meta.requiresAuth && !token) {
        next({ name: "/login" }); // Rediriger vers la page de login si non authentifié
    } else {
        next(); // Continuer la navigation
    }
});
export default router;
