<template>
    <div @click="redirectIfGuest">
        <div
            class="card mb-3 border-0 shadow-sm"
            v-for="(status, index) in statuses"
            :key="index"
        >
            <div class="card-body d-flex flex-column">
                <div class="d-flex align-items-center mb-3">
                    <img
                        class="rounded mr-3 shadow-sm"
                        width="40px"
                        src="/img/default-avatar.jpg"
                        alt=""
                    />
                    <div>
                        <h5 class="mb-1">{{ status.user_name }}</h5>
                        <div class="small text-muted">{{ status.ago }}</div>
                    </div>
                </div>

                <p class="card-text text-secondary">{{ status.body }}</p>
            </div>
            <div
                class="card-footer p-2 d-flex justify-content-between align-items-center"
            >
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
                    @click="like(status)"
                    v-else
                    class="btn btn-link btn-sm"
                    dusk="like-btn"
                >
                    <i class="far fa-thumbs-up text-primary mr-1"></i>
                    ME GUSTA
                </button>
                <div class="mr-2 text-secondary">
                    <i class="far fa-thumbs-up"></i>
                    <span dusk="likes-count">{{ status.likes_count }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            statuses: []
        };
    },
    mounted() {
        axios.get("/statuses").then(resp => {
            this.statuses = resp.data.data;
        });
        EventBus.$on("status-created", status => {
            this.statuses.unshift(status);
        });
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
};
</script>
