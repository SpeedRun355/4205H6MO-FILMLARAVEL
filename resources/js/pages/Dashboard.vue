<template>
        <div>
             <p>Bienvenue sur mon site {{ name }}</p>
             <p>
                 <router-link :to="{ name: 'about' }" class="btn btn-link">À propos</router-link>
             </p>
        </div>
</template>

<script>
export default {
    name: "Dashboard",
    data() {
        return {
            name: null,
        }
    },
    created() {
        if (window.Laravel.user) {
            this.name = window.Laravel.user.name
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    }
}
</script>
