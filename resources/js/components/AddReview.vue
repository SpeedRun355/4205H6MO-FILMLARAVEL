<template>
    <div class="container mt-4">
        <h4 class="text-center mb-4">Ajouter une review</h4>

        <form @submit.prevent="addReview" enctype="multipart/form-data" class="p-3 border rounded bg-light">
            <div class="mb-3">
                <label class="form-label">Review :</label>
                <input type="text" v-model="review.title" class="form-control" required />
            </div>

            <div class="mb-3">
                <label class="form-label">Comment :</label>
                <textarea v-model="review.content" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Image :</label>
                <input type="file" class="form-control" @change="onFileChange" />
            </div>

            <button type="submit" class="btn btn-primary" :disabled="loading">
                {{ loading ? "Envoi en cours..." : "Enregistrer" }}
            </button>

        </form>
    </div>
</template>

<script setup>

import { ref } from "vue";

const review = ref({
    title: "",
    content: "",
    photo: null,
});

const loading = ref(false);

function onFileChange(e) {
    review.value.photo = e.target.files[0];
}

async function addReview() {
    try {
        loading.value = true;

        // const id = this.$route.params.id;
        const token = localStorage.getItem("token");

        if (!token) {
            alert("Veuillez vous connecter d'abord.");
            return this.$router.push("/login");
        }
        // Préparer les données
        const formData = new FormData();
        formData.append("title", review.value.title);
        formData.append("content", review.value.content);
        if (review.value.photo) formData.append("photo", review.value.photo);

        // Envoi de l’review
        const response = await axios.post("/api/reviews", formData, {
            headers: {
                Authorization: `Bearer ${token}`,
                "Content-Type": "multipart/form-data",
            },
            //withCredentials: true,
        });

        alert("review ajouté avec succès !");
        window.location.href = "/reviews";
    } catch (error) {
        console.error("Erreur complète :", error);
        console.error("Réponse :", error.response?.data);
        alert("Erreur : " + (error.response?.data?.message || "Erreur lors de l’ajout"));
    }
    finally {
        loading.value = false;
    }
}


</script>

<style scoped>
.container {
    max-width: 600px;
}
</style>