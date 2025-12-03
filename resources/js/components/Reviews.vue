<template>

    <div>
         <div>
        <SearchBar />
    </div>
        <h4 class="text-center">Liste des reviews</h4><br />

        <!-- Le bouton est affiché même si l'utilisateur n'est pas connecté.
             Le click appelle goAdd() qui redirige vers /login si besoin. -->
        <router-link v-if="isLoggedIn" :to="{ name: 'addreview' }" class="btn btn-primary">
            Ajouter
        </router-link>

        <!-- Version alternative : toujours visible, redirige vers login si non connecté -->
        <!--  <button v-else @click="goAdd" class="btn btn-primary">
            Ajouter
        </button> -->

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th scope="col" class="text-center">Image</th>
                    <th scope="col" class="text-center">Review</th>
                    <th scope="col" class="text-center">Comment</th>
                    <th scope="col" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="review in reviews" :key="review.id">
                    <td style="text-align: center; vertical-align: middle;">
                        <div v-if="article.photo">
                            <img class="img-thumbnail" :src="'/images/upload/' + review.photo" />
                            <!-- // il est possible d'ajouter le style à l'image
                                <img class="img-thumbnail" :src="'/images/upload/' + article.photo"
                                style="height:100px;width:150px" /> -->

                        </div>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">{{ review.Review }}</td>
                    <td style="text-align: center; vertical-align: middle;">{{ review.Comment }}</td>
                    <td>
                        <div style="text-align: center; vertical-align: middle;">
                            <!--  <router-link :to="{ name: 'showarticle', params: { id: article.id } }"
                                class="btn btn-primary">View
                            </router-link>

                            <router-link :to="{ name: 'editarticle', params: { id: article.id } }"
                                class="btn btn-warning" v-if="isLoggedIn">Edit
                            </router-link> -->

                            <button class="btn btn-danger" @click="checkAuthBeforeDelete(review.id)">
                                Delete
                            </button>

                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import SearchBar from '../pages/SearchBar.vue';

export default {
    components: {
        SearchBar,
    },
    data() {
        return {
            reviews: [],
            isLoggedIn: false,
        }
    },
    created() {
        this.checkLoginStatus();
        axios.get('/api/reviews')
            .then(response => {
                this.reviews = response.data;
            })
            .catch(error => {
                console.error(error);
            });
    },
    methods: {
        checkLoginStatus() {
            // Si tu utilises session auth (Laravel) on lit window.Laravel.isLoggedin, sinon localStorage token
            if (window.Laravel && typeof window.Laravel.isLoggedin !== 'undefined') {
                this.isLoggedIn = !!window.Laravel.isLoggedin;
            } else {
                // fallback si tu utilises un token localStorage
                const token = localStorage.getItem("token");
                this.isLoggedIn = !!token;
            }
        },

        goAdd() {
             // Si pas connecté -> redirection vers la page de login
             if (!this.isLoggedIn) {
                 // Utilise le nom de route 'login' si tu l'as défini, sinon chemin '/login'
                 this.$router.push({ name: 'login' }).catch(() => { this.$router.push('/login') });
                 return;
             }
             // sinon rediriger vers addarticle (nom de route)
             this.$router.push({ name: 'addarticle' }).catch(() => { this.$router.push('/add') });
         },

        checkAuthBeforeDelete(id) {
            if (!this.isLoggedIn) {
                // redirection correcte : name ou path
                this.$router.push({ name: 'login' }).catch(() => { this.$router.push('/login') });
            } else {
                this.deleteReview(id);
            }
        },

        deleteReview(id) {
            if (!confirm("Are you sure to delete this review ?")) {
                return;
            }
            axios
                .delete(`/api/reviews/${id}`)
                .then(() => {
                    // Retirer le review du tableau local après suppression
                    this.reviews = this.reviews.filter(
                        (review) => review.id !== id
                    );
                })
                .catch((error) => {
                    console.error("Erreur lors de la suppression du review :", error);
                    // si erreur 401/403 -> rediriger vers login
                    if (error.response && (error.response.status === 401 || error.response.status === 403)) {
                        this.$router.push({ name: 'login' }).catch(() => { this.$router.push('/login') });
                    }
                });
        },
    },
}
</script>
