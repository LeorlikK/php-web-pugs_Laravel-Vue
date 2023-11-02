<template>
    <h3 class="comments-title">Комментарии:</h3>
    <div class="content comments-content">
        <div class="comments">
            <div v-if="this.$store.getters.getIsAuth" class="input-comment">
                <textarea placeholder="Введите комментарий:" v-model="input"></textarea>
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
                    @deleteComment="deleteComment"
                ></Comment>

                <div v-if="this.$store.getters.getIsAuth && comment.id === this.answerCommentId" class="input-comment input-answer">
                    <textarea placeholder="Введите комментарий:" v-model="answerInput"></textarea>
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
                    ></Comment>
                </template>

                <div v-show="!comment.loading && comment.comments_children.length > 0">
                    <a class="show-more"
                       v-if="comment.children_count > 0"
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
                <div class="comments-loading" v-show="comment.loading">
                    <span class="loading-text">Loading</span>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </template>
        </div>
    </div>
    <Paginator
        :current_page="pagination.current_page"
        :last_page="pagination.last_page"
        :total="pagination.total"
        @changePage="changePage"
    ></Paginator>
</template>

<script>
import axiosAuthUser from "@/axiosAuthUser";
import { API_ROUTES } from "@/routs";
import Paginator from "@/Components/Paginator.vue";
import Comment from "@/Components/Comments/Comment.vue";
import cookiesMixin from "@/mixins/authMixin";
import axios from "axios";
import errorsLogMixin from "@/mixins/errorsLogMixin";

export default {
    name: "Comments",
    mixins: [cookiesMixin, errorsLogMixin],
    components: { Comment, Paginator },
    props: {
        news_id: {
            type: Number,
        },
    },
    data() {
        return {
            comments: [],
            pagination: {
                current_page: 1,
                last_page: null,
                total: null,
            },
            input: null,
            answerInput: null,
            answerCommentId: false
        };
    },
    methods: {
        getComments(news_id, page) {
            axiosAuthUser.get(API_ROUTES.public.comments + `/${news_id}/${page}`)
                .then((data) => {
                    data = data.data;
                    data.data = data.data.map((comment) => {
                        comment.comments_children = [];
                        comment.loading = false
                        comment.answerFlag = false
                        return comment;
                    });

                    this.comments.splice(0);
                    this.comments.push(...data.data);
                    this.pagination.current_page = data.meta.current_page;
                    this.pagination.last_page = data.meta.last_page;
                    this.pagination.total = data.meta.total;
                })
                .catch((errors) => {
                    console.log(errors);
                });
        },
        getCommentsChildren(page, parent_comment, comment) {
            if (comment.comments_children.pagination?.current_page >= comment.comments_children.pagination?.last_page) {
                comment.comments_children.splice(0);
                delete comment.comments_children.pagination;
            } else {
                comment.loading = true
                axios.get(API_ROUTES.public.comments + `/${this.news_id}/${page}/${parent_comment}`)
                    .then((data) => {
                        comment.comments_children.pagination = {
                            current_page: data.data.meta.current_page,
                            last_page: data.data.meta.last_page,
                            total: data.data.meta.total,
                        };
                        comment.comments_children.push(...data.data.data);
                        comment.loading = false
                    })
                    .catch((errors) => {
                        console.log(errors);
                    });
            }
        },
        inputComment(parent_comment) {
            const data = {
                text: this.input,
                news_id: this.news_id,
                parent_comment: parent_comment
            };
            axiosAuthUser.post(API_ROUTES.protected.comments_store, data)
                .then(data => {
                    console.log(data.data.comment)
                    const comment = data.data.comment

                    comment.comments_children = [];
                    comment.loading = false

                    this.comments.unshift(comment)
                    this.comments.pop();
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
            axiosAuthUser.post(API_ROUTES.protected.comments_store, data)
                .then(data => {
                    console.log(data.data.comment)
                    const comment = data.data.comment

                    comment_parent.comments_children.unshift(comment)
                    comment_parent.children_count += 1
                    this.answerCancel()
                    this.answerCommentId = null
                })
                .catch(errors => {
                    this.errorsLog(errors)
                });
        },
        cancel() {
            this.input = null
        },
        answerCancel() {
            this.answerCommentId = null
            this.answerInput = null
        },
        hidden(comment) {
            comment.comments_children.splice(0);
            delete comment.comments_children.pagination;
        },
        changePage(page) {
            this.getComments(this.news_id, page);
        },
        changeAnswerCommentId(id) {
            this.answerCommentId = id
        },
        deleteComment(comment) {
            console.log(comment)
            axiosAuthUser.post(API_ROUTES.protected.comments_delete + `/${comment.id}`)
                .then(data => {
                    console.log(data)
                })
                .catch(errors => {
                    this.errorsLog(errors)
                });
        }
    },
    mounted() {
        this.getComments(this.news_id, this.pagination.current_page);
    },
};
</script>

<style scoped>

</style>
