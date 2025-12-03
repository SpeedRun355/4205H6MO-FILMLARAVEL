import axios from 'axios';

const api = axios.create({
    /*  baseURL: import.meta.env.VITE_API_BASE_URL || '/api', // ou '/api'    Pour VITE*/
    baseURL: process.env.MIX_API_BASE_URL, // POur MIX
    withCredentials: true // important pour sanctum cookie
});

// Interceptor pour ajouter Bearer si token stocké
api.interceptors.request.use(config => {
    const token = localStorage.getItem('token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

export default api;
