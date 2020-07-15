<template>
    <form @submit.prevent="addComment" v-if="isAuthenticated" class="mb-3">
        <div class="d-flex align-items-center">
            <img width="34px" class="rounded shadow-sm mr-2" :src="currentUser.avatar" :alt="currentUser.name">
            <div class="input-group">
                <textarea class="form-control border-0 shadow-sm" rows="1" name="comment" v-model="newComment" placeholder="Escriba un comentario..." required></textarea>
                <div class="input-group-append">
                    <button type="submit" dusk="comment-btn" class="btn btn-primary">Enviar</button>
                </div>
            </div>
        </div>
    </form>
    <div v-else class="mb-3 text-center">
        Debes <a href="/login">autenticarte</a> para poder comentar
    </div>
</template>

<script>
export default {
    props: {
        statusId: {
            type: Number,
            required: true
        }
    },
    data(){
        return {
            newComment: '',
        }
    },
    methods: {
        addComment(){
            axios.post(`/statuses/${this.statusId}/comments`, {body: this.newComment})
            .then(res => {
                this.newComment= '';
                EventBus.$emit(`statuses.${this.statusId}.comments`,res.data.data);
            })
            .catch(err => {
                console.log(err.response.data)
            });
        },
    }
}
</script>
