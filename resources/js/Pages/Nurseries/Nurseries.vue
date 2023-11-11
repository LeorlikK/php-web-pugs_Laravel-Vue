<template>
    <div class="container-nurseries">
        <h3 class="content-title">Питомники мопсов</h3>
        <div class="content content-nurseries">
            <div v-if="posts" v-for="post in posts" class="nurseries">
                <h1>{{post.title}}</h1>
                <div class="image">
                    <img class="image" :src="`/storage${post.image_url}`" alt="#">
                </div>
                <p>{{post.text}}</p>
                <div class="contact-info">
                    <button class="btn">
                        <a :href="'tel:' + post.phone">Позвонить</a>
                    </button>

                    <button class="btn">
                        <a :href=post.address target="_blank">Сайт</a>
                    </button>
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
import axiosAuthUser from "@/axiosAuthUser";
import {API_ROUTES} from "@/routs";
import Paginator from "@/Components/Paginator.vue";
import router from "@/router";

export default {
    name: "Nurseries",
    components: {Paginator},
    data(){
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
        getNurseries() {
            this.page = router.currentRoute.value.query.page
            axiosAuthUser.get(`${API_ROUTES.public.nurseries}`, {
                params: {
                    page: this.page
                },
            })
                .then(data => {
                    data = data.data
                    this.posts.splice(0)
                    this.posts.push(...data.data)
                    this.pagination.current_page = data.meta.current_page
                    this.pagination.last_page = data.meta.last_page
                    this.pagination.total = data.meta.total
                })
                .catch(errors => {
                    console.log(errors);
                })
        },
        changePage(page) {
            router.replace({ query: { page: page } })
            router.currentRoute.value.query.page = page
            this.getNurseries()
        }
    },
    mounted() {
        this.getNurseries()
    }
}
</script>

<style scoped>

</style>
