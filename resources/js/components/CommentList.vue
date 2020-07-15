<template>
    <div>
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
    </div>
</template>

<script>
import LikeBtn from './LikeBtn'
export default {
    components: { LikeBtn },
    props: {
        comments: {
            type: Array,
            required: true
        },
        statusId: {
            type: Number,
            required: true
        }
    },
    mounted(){
        EventBus.$on(`statuses.${this.statusId}.comments`, comment => {
            this.comments.push(comment);
        });
        Echo.channel(`statuses.${this.statusId}.comments`).listen('CommentCreated', ({comment})=> {
            this.comments.push(comment);
        });
    },
}
</script>
