<template>
    <div class="content">
        <div class="news">
            <div v-if="posts" v-for="post in posts">
                <h1><a href="#">{{ post.title }}</a></h1><hr>
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
        <Paginator
            :current_page="pagination.current_page"
            :last_page="pagination.last_page"
            :total="pagination.total"
            @changePage="changePage"
        ></Paginator>
    </div>

</template>

<script>
import axiosAuthUser from "@/axiosAuthUser";
import {API_ROUTES} from "@/routs";
import Paginator from "@/Components/Paginator.vue";

export default {
    name: "Index",
    components: {Paginator},
    data() {
        return {
            posts: [],
            pagination: {
                current_page: null,
                last_page: null,
                total: null,
            },
            page: 1
        }
    },
    methods: {
        getPosts(){
            axiosAuthUser.get(`${API_ROUTES.public.news}`, {
                params: {
                    page: this.page
                }
            })
                .then(data => {
                    data = data.data
                    this.posts.splice(0)
                    this.posts.push(...data.data)
                    this.pagination.current_page = data.meta.current_page
                    this.pagination.last_page = data.meta.last_page
                    this.pagination.total = data.meta.total
                    console.log(data)
                })
                .catch(errors => {
                    console.log(errors)
                })
        },
        changePage(page) {
            this.page = page
            this.getPosts()
        }
    },
    mounted() {
        this.getPosts()
    }
}
</script>

<style scoped>

</style>
