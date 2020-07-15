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
        <div class="card-footer pb-0" v-if="isAuthenticated || status.comments.length">
            <comment-list
                :comments = "status.comments"
                :status-id = "status.id"
            ></comment-list>

            <comment-form
                :status-id = "status.id"
            ></comment-form>
        </div>
    </div>
</template>

<script>
import LikeBtn from './LikeBtn'
import CommentList from './CommentList'
import CommentForm from './CommentForm'
export default {
    components: { LikeBtn, CommentList, CommentForm },
    props:{
        status: {
            type: Object,
            required: true
        }
    }
}
</script>
