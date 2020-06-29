<template>
    <button
        v-if="status.is_liked"
        @click="unlike(status)"
        class="btn btn-link btn-sm"
        dusk="unlike-btn"
    >
        <i class="fa fa-thumbs-up text-primary mr-1"></i>
        <strong>TE GUSTA</strong>
    </button>
    <button
        v-else
        @click="like(status)"
        class="btn btn-link btn-sm"
        dusk="like-btn"
    >
        <i class="far fa-thumbs-up text-primary mr-1"></i>
        ME GUSTA
    </button>
</template>

<script>
export default {
    props:{
        status: {
            type: Object,
            required: true
        }
    },
    methods: {
        like(status) {
            axios.post(`/statuses/${status.id}/likes`).then(resp => {
                status.is_liked = true;
                status.likes_count++;
            });
        },
        unlike(status) {
            axios.delete(`/statuses/${status.id}/likes`).then(resp => {
                status.is_liked = false;
                status.likes_count--;
            });
        }
    }
}
</script>
