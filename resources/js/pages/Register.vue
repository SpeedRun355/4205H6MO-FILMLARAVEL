<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="alert alert-danger" v-if="error">
                    {{ error }}
                </div>

                <div class="card">
                    <div class="card-header">Register</div>
                    <div class="card-body">

                        <form @submit.prevent="handleRegister">

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-md-right">Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" v-model="name" required autocomplete="off">
                                </div>
                            </div><br>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-md-right">Email</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" v-model="email" required
                                        autocomplete="off">
                                </div>
                            </div><br>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" v-model="password" required
                                        autocomplete="off">
                                </div>
                            </div><br>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" v-model="c_password" required
                                        autocomplete="off">
                                </div>
                            </div><br>

                            <div class="form-group row">
                                <!-- widget container -->
                                <div ref="recaptchaWrapper" class="col-md-6"></div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-8 offset-md-4">
                                    <button class="btn btn-primary">Register</button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, watch } from 'vue';
import api from '../axios'; // adapter le chemin au besoin
import { useRouter } from 'vue-router'; // pour pouvoir utiliser router.push
const router = useRouter();

const props = defineProps({
    visible: { type: Boolean, default: false }  //afficher/masquer la fenêtre d'inscription.
});

const name = ref('');
const email = ref('');
const password = ref('');
const c_password = ref('');
const error = ref(null);
const loading = ref(false);

const recaptchaWidgetId = ref(null);
const recaptchaToken = ref(null);
const recaptchaWrapper = ref(null);

/* //ou bien
const data = ref({
    name:"",
    email:"",
    password:"",
    c_password:"",
    error: null,
    loading: false, ...

}); */

const SITE_KEY = process.env.MIX_RECAPTCHA_SITE_KEY || (window.RECAPTCHA_SITE_KEY || ''); // fallback pour MIX
//const SITE_KEY = import.meta.env.VITE_RECAPTCHA_SITE_KEY || (window.RECAPTCHA_SITE_KEY || ''); //fallback pour VITE


function renderRecaptcha() {
    if (!window.grecaptcha || !recaptchaWrapper.value) return;
    // render once
    if (recaptchaWidgetId.value !== null) {
        try { window.grecaptcha.reset(recaptchaWidgetId.value); } catch { }
        return;
    }
    recaptchaWidgetId.value = window.grecaptcha.render(recaptchaWrapper.value, {
        'sitekey': SITE_KEY,
        'callback': (token) => {
            recaptchaToken.value = token;
        },
        'expired-callback': () => { recaptchaToken.value = null; }
    });
}

onMounted(() => {
    // If grecaptcha not ready yet, poll until ready
    let tries = 0;
    const interval = setInterval(() => {
        if (window.grecaptcha && window.grecaptcha.render) {
            renderRecaptcha();
            clearInterval(interval);
        } else if (tries++ > 20) {
            clearInterval(interval);
            console.warn('reCAPTCHA not loaded');
        }
    }, 300);
});

onBeforeUnmount(() => {
    if (recaptchaWidgetId.value !== null && window.grecaptcha && window.grecaptcha.reset) {
        window.grecaptcha.reset(recaptchaWidgetId.value);
    }
});

async function handleRegister() {
    error.value = null;
    if (!recaptchaToken.value) {
        error.value = 'Merci de confirmer que vous n\'êtes pas un robot.';
        return;
    }

    loading.value = true;
    try {
        // Option : get CSRF cookie for sanctum if using cookie auth
        await api.get('/sanctum/csrf-cookie');

        const res = await api.post('/register', {
            name: name.value,
            email: email.value,
            password: password.value,
            c_password: c_password.value,
            'g-recaptcha-response': recaptchaToken.value
        });

        console.log({
            name: this.name,
            email: this.email,
            password: this.password,
            c_password: this.c_password,
            'g-recaptcha-response': this.gRecaptchaResponse // si vous en avez une
        });

        if (res.data.success) {
            // stockage token si tu veux (si renvoyé)
            if (res.data.data?.token) {
                localStorage.setItem('token', res.data.data.token);
                router.push("/login");
            }

        } else {
            error.value = res.data.message || 'Erreur inscription';
        }
    } catch (err) {
        if (err.response?.status === 422) {
            // validation errors
            const errors = err.response.data.errors || {};
            error.value = Object.values(errors).flat().join(' ');
        } else {
            error.value = 'Erreur lors de la requête';
            console.log('Réponse:', err.response?.data || err.message);
        }
    } finally {
        loading.value = false;
        // reset recaptcha widget to allow a new token next time
        if (window.grecaptcha && recaptchaWidgetId.value !== null) {
            window.grecaptcha.reset(recaptchaWidgetId.value);
            recaptchaToken.value = null;
        }
    }
}


</script>