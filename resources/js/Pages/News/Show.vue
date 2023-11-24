<template>
    <div class="container-news-show">
        <div class="content content-news">
            <div class="news news-show">
                <div>
                    <router-link :to="{name: 'news', query: {page: $router.currentRoute.value.query.page ?? 1}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-90deg-left" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1.146 4.854a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H12.5A2.5 2.5 0 0 1 15 6.5v8a.5.5 0 0 1-1 0v-8A1.5 1.5 0 0 0 12.5 5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4z"></path>
                        </svg>
                    </router-link>

                    <h1>{{title}}</h1><hr>
                    <div class="image">
                        <img class="image" :src="this.path + image_url" alt="#">
                    </div><hr>
                    <div>
                        <p>{{ text }}</p>
                    </div><hr>
                    <div class="news-footer">
                        <p class="author">Автор: {{user}}</p>
                        <p class="date">Дата публикации: {{ created_at }}</p>
                    </div>
                </div>
            </div>
        </div>
        <Comments
            v-if="news_id !== null"
            :news_id=news_id
        ></Comments>
    </div>

</template>

<script>
import myAxios from "@/myAxios";
import {API_ROUTES} from "@/routs";
import router from "@/router";
import Comments from "@/Components/Comments/Comments.vue";
import DeleteComment from "@/Components/Сonfirmation/Confirm.vue";
import inputErrorsMixin from "@/mixins/inputErrorsMixin.js";
import logMixin from "@/mixins/logMixin.js";
import fileMixin from "@/mixins/fileMixin";

export default {
    name: "Show",
    components: {DeleteComment, Comments},
    mixins: [inputErrorsMixin, logMixin, fileMixin],
    data() {
        return {
            news_id: null,
            image_url: null,
            title: null,
            text: null,
            user: null,
            created_at: null,
            updated_at: null,
        }
    },
    methods: {
        getPost() {
            this.news_id = router.currentRoute.value.query.id
            myAxios.get(`${API_ROUTES.public.news_show}`, {
                params: {
                    id: this.news_id
                },
            })
                .then(data => {
                    this.dataLog(data)
                    data = data.data.data
                    this.image_url = data.image_url
                    this.title = data.title
                    this.text = data.text
                    this.user = data.user
                    this.created_at = data.created_at
                    this.updated_at = data.updated_at
                })
                .catch(errors => {
                    this.errorsLog(errors)
                })
        }
    },
    mounted() {
        this.getPost()
    }
}
</script>

<style scoped>

</style>
