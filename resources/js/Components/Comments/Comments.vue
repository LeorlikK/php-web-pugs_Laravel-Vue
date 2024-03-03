<template>
    <h3 class="comments-title">Комментарии:</h3>
    <div class="content comments-content">
        <div class="comments">
            <div v-if="this.getIsAuth" class="input-comment">
                <textarea v-model="inputField" placeholder="Введите комментарий:" ></textarea>
                <div>
                    <a @click.prevent="cancel">Отмена</a>
                    <a @click.prevent="inputComment(null)">Оставить комментарий</a>
                </div>
            </div>
            <template
                v-if="comments"
                v-for="comment in comments"
                :key="comment.id">
                <Comment
                    :comment="comment"
                    :answerCommentId="answerCommentId"
                    @getCommentsChildren="getCommentsChildren"
                    @hidden="hidden"
                    @changeAnswerCommentId="changeAnswerCommentId"
                    @confirmDelete="confirm"
                ></Comment>

                <div v-if="this.getIsAuth && comment.id === this.answerCommentId" class="input-comment input-answer">
                    <textarea v-model="answerInput" placeholder="Введите комментарий:" ref="textareaId"></textarea>
                    <div>
                        <a @click.prevent="answerCancel">Отмена</a>
                        <a @click.prevent="answerInputComment(comment)">Ответить</a>
                    </div>
                </div>

                <template
                    v-if="comment.comments_children.length > 0"
                    v-for="comment_children in comment.comments_children"
                    :key="comment_children.id">
                    <Comment class="comments-children"
                        :comment="comment_children"
                        @confirmDelete="confirm"
                    ></Comment>
                </template>

                <div v-show="!comment.loading && comment.comments_children.length > 0">
                    <a v-if="comment.children_count > 0" class="show-more btn-comment"
                       @click.prevent="getCommentsChildren(comment.comments_children.pagination?.current_page + 1, comment.id, comment)">
                        {{
                            comment.comments_children.pagination?.current_page >= comment.comments_children.pagination?.last_page
                                ? 'Скрыть'
                                : comment.comments_children.length > 0
                                    ? 'Другие ответы'
                                    : `Показать: ${comment.children_count}`
                        }}
                    </a>
                </div>
                <div v-show="comment.loading" class="comments-loading">
                    <span class="loading-text">Loading</span>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </template>
        </div>
    </div>
    <div v-observer="{news_id: news_id, current_page: pagination.current_page, method: getComments}"
         style="width: 100%; height: 50px">
    </div>
    <Confirm
        text="Удалить комментарий?"
        :question="question"
        @answer="deleteComment"
    ></Confirm>
</template>

<script>
import myAxios from "@/myAxios";
import { API_ROUTES } from "@/routs";
import Paginator from "@/Components/Paginator.vue";
import Comment from "@/Components/Comments/Comment.vue";
import inputErrorsMixin from "@/mixins/inputErrorsMixin";
import logMixin from "@/mixins/logMixin";
import Confirm from "@/Components/Сonfirmation/Confirm.vue";
import {mapGetters} from "vuex";
import paginationMixin from "@/mixins/paginationMixin";
import confirmMixin from "@/mixins/confirmMixin";
import echoMixin from "@/mixins/echoMixin";

export default {
    name: "Comments",
    mixins: [inputErrorsMixin, logMixin, paginationMixin, confirmMixin, echoMixin],
    components: {Confirm, Comment, Paginator },
    props: {
        news_id: {},
    },
    data() {
        return {
            pagination: {
                current_page: 1
            },
            comments: [],
            inputField: null,
            answerInput: null,
            answerCommentId: false,
        };
    },
    computed: {
        ...mapGetters('authModule', {
            getIsAuth: 'getIsAuth'
        })
    },
    methods: {
        getComments(news_id, page) {
            myAxios.get(API_ROUTES.public.comments + `/${news_id}/${page}`)
                .then((data) => {
                    this.dataLog(data)
                    data = data.data;
                    data.data = data.data.map((comment) => {
                        comment.comments_children = [];
                        comment.loading = false
                        comment.answerFlag = false
                        return comment;
                    });
                    this.comments.push(...data.data);
                    this.assigningValuesPaginator(data)
                })
                .catch((errors) => {
                    this.errorsLog(errors)
                });
        },
        getCommentsChildren(page, parent_comment, comment) {
            if (comment.comments_children.pagination?.current_page >= comment.comments_children.pagination?.last_page) {
                comment.comments_children.splice(0);
                delete comment.comments_children.pagination;
            } else {
                comment.loading = true
                myAxios.get(API_ROUTES.public.comments + `/${this.news_id}/${page}/${parent_comment}`)
                    .then((data) => {
                        this.dataLog(data)
                        comment.comments_children.pagination = {
                            current_page: data.data.meta.current_page,
                            last_page: data.data.meta.last_page,
                            total: data.data.meta.total,
                        };
                        const array = []
                        comment.comments_children.map(com => {
                            array.push(com.id)
                        })
                        const filterComment = data.data.data.filter(com => !array.includes(com.id));
                        comment.comments_children.push(...filterComment);
                        comment.loading = false
                    })
                    .catch((errors) => {
                        this.errorsLog(errors)
                    });
            }
        },
        inputComment(parent_comment) {
            const data = {
                text: this.inputField,
                news_id: this.news_id,
                parent_comment: parent_comment
            };
            myAxios.post(API_ROUTES.protected.comments_store, data)
                .then(data => {
                    this.dataLog(data)
                    this.inputField = null
                    const comment = data.data.data

                    comment.comments_children = [];
                    comment.loading = false
                    this.comments.unshift(comment)
                })
                .catch(errors => {
                    this.errorsLog(errors)
                });
        },
        answerInputComment(comment_parent) {
            const data = {
                text: this.answerInput,
                news_id: this.news_id,
                parent_comment: comment_parent.id
            };
            myAxios.post(API_ROUTES.protected.comments_store, data)
                .then(data => {
                    this.dataLog(data)
                    const comment = data.data.data

                    comment_parent.comments_children.push(comment)
                    comment_parent.children_count += 1
                    this.answerCancel()
                    this.answerCommentId = null
                })
                .catch(errors => {
                    this.errorsLog(errors)
                });
        },
        cancel() {
            this.inputField = null
        },
        answerCancel() {
            this.answerCommentId = null
            this.answerInput = null
        },
        hidden(comment) {
            comment.comments_children.splice(0);
            delete comment.comments_children.pagination;
        },
        changeAnswerCommentId(id) {
            this.answerCommentId = id
            const textarea = this.$refs.textareaId
            if (textarea) {
                textarea.removeAttribute('autofocus');
            }
        },
        deleteComment(confirm) {
            this.question = false
            if (confirm){
                const comment = this.objQuestion
                this.objQuestion = null
                myAxios.post(API_ROUTES.protected.comments_delete + `/${comment.id}`)
                    .then(data => {
                        this.dataLog(data)
                        if (comment.parent_comment) {
                            const indexParentComment = this.comments.findIndex(c => c.id === comment.parent_comment);
                            const parent_comment = this.comments[indexParentComment]
                            const indexChildrenComment = parent_comment.comments_children.findIndex(c => c.id === comment.id);
                            parent_comment.comments_children.splice(indexChildrenComment, 1);
                            this.comments[indexParentComment].children_count -= 1
                        } else {
                            const indexComment = this.comments.findIndex(c => c.id === comment.id);
                            this.comments.splice(indexComment, 1);
                        }
                    })
                    .catch(errors => {
                        this.errorsLog(errors)
                    });
            }else {
                this.objQuestion = null
            }
        },
        echoHandlerComment(response) {
            this.dataLog(response)
            this.inputField = null
            const comment = response.comment

            if (comment.parent_comment) {
                const needComment = this.comments.filter(com => com.id === comment.parent_comment);
                needComment[0].comments_children.push(comment);
            } else {
                comment.comments_children = [];
                comment.loading = false
                this.comments.unshift(comment)
            }
        }
    },
    // created() {
    //     const echo = this.$store.getters['echoModule/Echo']
    //     this.connectEcho(echo, 'news_comments', '.news_comments', this.echoHandlerComment)
    // },
    //
    // mounted() {
    //     this.getComments(this.news_id, this.pagination.current_page);
    // },
    // beforeUnmount() {
    //     this.disconnectEcho()
    // },
};
</script>

<style scoped>

</style>
