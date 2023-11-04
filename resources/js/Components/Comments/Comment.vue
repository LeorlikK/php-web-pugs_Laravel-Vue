<template>
    <div>
        <img :src="`/storage${comment.user.avatar}`" alt="#">
        <p class="user-name"><span>{{ comment.user.login}}</span><span>: {{ comment.created_at_diff }} назад</span></p>
        <div class="answer-comment" >
            <a v-if="comment.user.login === this.$store.getters.getLogin" @click.prevent="this.deleteComment(comment)">удалить</a>
            <template v-if="this.$store.getters.getIsAuth && comment.comments_children">
                <a v-if="comment.id === this.answerCommentId" @click.prevent="this.changeAnswerCommentId(false)">отмена</a>
                <a v-else @click.prevent="this.changeAnswerCommentId(comment.id)">ответить</a>
            </template>
        </div>
        <p class="user-comment">{{comment.text}}</p>
        <div v-show="!comment.loading">
            <a class="show-more"
               v-if="comment.children_count > 0"
               @click.prevent="comment.comments_children.length > 0 ?
               hidden(comment) :
               getCommentsChildren(comment.comments_children.pagination?.current_page + 1, comment.id, comment)
            ">
                {{
                    comment.comments_children.length > 0 ? 'Скрыть' : `Показать: ${comment.children_count}`
                }}
            </a>
        </div>
    </div>
</template>

<script>
export default {
    name: "Comment",
    emits: ['getCommentsChildren', 'hidden', 'changeAnswerCommentId', 'confirmDelete'],
    props: {
        comment: {},
        answerCommentId: {}
    },
    methods: {
        getCommentsChildren(page, comment_id, comment) {
            this.$emit('getCommentsChildren', page, comment_id, comment)
        },
        hidden(comment) {
            this.$emit('hidden', comment)
        },
        changeAnswerCommentId(id) {
            this.$emit('changeAnswerCommentId', id)
        },
        deleteComment(comment) {
            this.$emit('confirmDelete', comment)
        }
    },
}
</script>

<style scoped>

</style>
