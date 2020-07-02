<template>
    <div class="card mb-3 border-0 shadow-sm">
        <div class="card-body d-flex flex-column">
            <div class="d-flex align-items-center mb-3">
                <img
                    class="rounded mr-3 shadow-sm"
                    width="40px"
                    :src="status.user.avatar"
                    :alt= "status.user.name"
                />
                <div>
                    <h5 class="mb-1">
                        <a :href="status.user.link">{{ status.user.name }}</a>
                    </h5>
                    <div class="small text-muted">{{ status.ago }}</div>
                </div>
            </div>

            <p class="card-text text-secondary">{{ status.body }}</p>
        </div>
        <div
            class="card-footer p-2 d-flex justify-content-between align-items-center"
        >
            <like-btn
                :model="status"
                :url="`/statuses/${status.id}/likes`"
                dusk="like-btn"
            ></like-btn>

            <div class="mr-2 text-secondary">
                <i class="far fa-thumbs-up"></i>
                <span dusk="likes-count">{{ status.likes_count }}</span>
            </div>
        </div>
        <div class="card-footer">
            <div v-for="(comment,index) in comments" :key="index" class="mb-3">
                <div class="d-flex">
                    <img height="34px" width="34px" class="rounded shadow-sm mr-2" :src="comment.user.avatar" :alt="comment.user.name">
                    <div class="flex-grow-1">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-2 text-secondary">
                                <a :href="comment.user.link"><strong>{{ comment.user.name }}</strong></a>
                                {{ comment.body }}
                            </div>
                        </div>
                        <small class="float-right badge badge-pill badge-primary py-1 px-2 mt-1" dusk="comment-likes-count">
                            <i class="fa fa-thumbs-up"></i>
                            {{ comment.likes_count }}
                        </small>

                        <like-btn
                            :model="comment"
                            :url="`/comments/${comment.id}/likes`"
                            dusk="comment-like-btn"
                            class="comment-like-btn"
                        ></like-btn>
                    </div>
                </div>



            </div>
            <form @submit.prevent="addComment" v-if="isAuthenticated">
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
        </div>
    </div>
</template>

<script>
import LikeBtn from './LikeBtn'
export default {
    components: { LikeBtn },
    props:{
        status: {
            type: Object,
            required: true
        }
    },
    data(){
        return {
            newComment: '',
            comments: this.status.comments
        }
    },
    methods: {
        addComment(){
            axios.post(`/statuses/${this.status.id}/comments`, {body: this.newComment})
            .then(res => {
                this.comments.push(res.data.data)
            })
            .catch(err => {
                console.log(err.response.data)
            });
        },
    }

}
</script>
