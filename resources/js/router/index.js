import { createWebHistory, createRouter } from "vue-router";

import Home from '../pages/Home';
import Dashboard from '../pages/Dashboard';
import Reviews from '../components/Reviews';
import Login from '../pages/Login';
import Register from '../pages/Register';
import EditReview from '../components/EditReview';
import AddReview from '../components/AddReview';

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
        component: Reviews
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'register',
        path: '/register',
        component: Register
    },
    {
        name: 'addreview',
        path: '/add',
        component: AddReview
    },
    {
        name: 'editvreview',
        path: '/edit/:id',
        component: EditReview
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
