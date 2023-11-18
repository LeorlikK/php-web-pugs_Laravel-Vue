<template>
    <div class="container-news">
        <h3 class="content-title">Новости</h3>
        <div class="content content-news">
            <div class="news">
                <div v-if="posts" v-for="post in posts">
                    <h1>
                        <router-link :to="{name: 'news_show', query: {id: post.id, page: pagination.current_page}}">
                            {{post.title}}
                        </router-link>
                    </h1><hr>
                    <div class="image">
                        <img class="image" :src="`/storage${post.image_url}`" alt="#">
                    </div><hr>
                    <div>
                        <h2>{{ post.short }}</h2>
                    </div><hr>
                    <div class="news-footer">
                        <p>Автор: {{post.user}}</p>
                        <p>Дата публикации: {{ post.created_at }}</p>
                    </div>
                </div>
            </div>
        </div>
        <Paginator
            v-if="pagination.last_page > 1"
            :current_page="pagination.current_page"
            :last_page="pagination.last_page"
            :total="pagination.total"
            @changePage="changePage"
        ></Paginator>
    </div>

</template>

<script>
import myAxios from "@/myAxios";
import {API_ROUTES} from "@/routs";
import Paginator from "@/Components/Paginator.vue";
import router from "@/router";
import inputErrorsMixin from "@/mixins/inputErrorsMixin";
import logMixin from "@/mixins/logMixin";

export default {
    name: "Index",
    components: {Paginator},
    mixins: [inputErrorsMixin, logMixin],
    data() {
        return {
            posts: [],
            pagination: {
                current_page: 1,
                last_page: null,
                total: null,
            },
        }
    },
    methods: {
        getPosts(page){
            this.pagination.current_page = page
            myAxios.get(`${API_ROUTES.public.news}`, {
                params: {
                    page: String(this.pagination.current_page)
                },
            })
                .then(data => {
                    this.dataLog(data)
                    data = data.data
                    this.posts.splice(0)
                    this.posts.push(...data.data)
                    this.pagination.current_page = data.meta.current_page
                    this.pagination.last_page = data.meta.last_page
                    this.pagination.total = data.meta.total
                })
                .catch(errors => {
                    this.errorsLog(errors)
                })
        },
        changePage(page) {
            router.replace({ query: { page: page } })
            router.currentRoute.value.query.page = page
            this.getPosts(page)
        },
    },
    mounted() {
        this.getPosts(router.currentRoute.value.query.page)
    }
}
</script>

<style scoped>

</style>
