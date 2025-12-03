<template>
    <div class="container mt-4">
        <h4 class="text-center mb-4">Modifier la review</h4>

        <form @submit.prevent="EditReview" enctype="multipart/form-data" class="p-3 border rounded bg-light">
            <div class="mb-3">
                <label class="form-label">Review :</label>
                <input type="text" v-model="review.review" class="form-control" required />
            </div>

            <div class="mb-3">
                <label class="form-label">Comment :</label>
                <textarea v-model="review.comment" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Image (laisser vide pour conserver) :</label>
                <input type="file" class="form-control" @change="onFileChange" />
            </div>

            <div v-if="existingPhoto" class="mb-3">
                <label class="form-label">Photo actuelle :</label>
                <div>
                    <img :src="existingPhotoUrl" alt="photo" style="max-width:200px; max-height:200px;" />
                </div>
            </div>

            <button type="submit" class="btn btn-primary" :disabled="loading">
                {{ loading ? "Envoi en cours..." : "Mettre à jour" }}
            </button>

        </form>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();

const id = route.params.id;

const review = ref({
    review: '',
    comment: '',
    photo: null,
});
const existingPhoto = ref(null);
const loading = ref(false);

const existingPhotoUrl = computed(() => {
    if (!existingPhoto.value) return null;
    // If the API returns a path, make it absolute if needed
    if (existingPhoto.value.startsWith('http')) return existingPhoto.value;
    return `${window.location.origin}/images/upload/${existingPhoto.value}`;
});

function onFileChange(e) {
    review.value.photo = e.target.files[0];
}

async function fetchReview() {
    try {
        const resp = await axios.get(`/api/reviews/${id}`);
        const data = resp.data;
        // If the controller returns the model directly, it will be an object with attributes
        review.value.review = data.review ?? data.review ?? '';
        review.value.comment = data.comment ?? '';
        existingPhoto.value = data.photo ?? null;
    } catch (err) {
        console.error('Erreur récupération review', err);
        alert('Impossible de charger la review');
        router.push('/reviews');
    }
}

async function EditReview() {
    loading.value = true;
    try {
        const token = localStorage.getItem('token');
        if (!token) {
            alert('Veuillez vous connecter.');
            return router.push('/login');
        }

        const formData = new FormData();
        formData.append('review', review.value.review);
        formData.append('comment', review.value.comment);
        if (review.value.photo) formData.append('photo', review.value.photo);

        // Use the PUT endpoint defined in routes: /api/reviews/update/{id}
        const url = `/api/reviews/update/${id}`;

        await axios.put(url, formData, {
            headers: {
                Authorization: `Bearer ${token}`,
                'Content-Type': 'multipart/form-data',
            },
        });

        alert('Review modifiée avec succès');
        window.location.href = '/reviews';
    } catch (err) {
        console.error('Erreur mise à jour :', err);
        alert('Erreur lors de la mise à jour : ' + (err.response?.data?.message || 'Erreur'));
    } finally {
        loading.value = false;
    }
}

onMounted(() => {
    fetchReview();
});

</script>

<style scoped>
.container {
    max-width: 600px;
}
</style>
