<template>
    <MediaMenu></MediaMenu>
    <h3 class="content-title">Photos</h3>
    <div class="content media-content">
        <div class="media">
            <div v-for="post in posts" class="photo">
                <div>
                    <img @click.prevent="changeShowImage(post.url)" class="image photo-img" :src="`/storage${post.url}`" alt="#">
                </div>
                <p>{{ post.name }}</p>
            </div>
        </div>
    </div>
    <BigSize
        @changeShowImage="changeShowImage"
        :showImage="showImage"
    ></BigSize>
    <Paginator
        :current_page="pagination.current_page"
        :last_page="pagination.last_page"
        :total="pagination.total"
        @changePage="changePage"
    ></Paginator>
</template>

<script>
import Paginator from "@/Components/Paginator.vue";
import {API_ROUTES} from "@/routs";
import axiosAuthUser from "@/axiosAuthUser";
import BigSize from "@/Media/BigSize.vue";
import router from "@/router";
import MediaMenu from "@/Components/Menu/MediaMenu.vue";
export default {
    name: "Photo",
    components: {MediaMenu, BigSize, Paginator},
    data() {
        return {
            showImage: false,
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
            axiosAuthUser.get(`${API_ROUTES.public.photos}`, {
                params: {
                    page: String(this.pagination.current_page)
                },
            })
                .then(data => {
                    console.log(data)
                    data = data.data
                    this.posts.splice(0)
                    this.posts.push(...data.data)
                    this.pagination.current_page = data.meta.current_page
                    this.pagination.last_page = data.meta.last_page
                    this.pagination.total = data.meta.total
                })
                .catch(errors => {
                    console.log(errors)
                })
        },
        changeShowImage(value) {
            this.showImage = value
        },
        changePage(page) {
            router.replace({ query: { page: page } })
            router.currentRoute.value.query.page = page
            this.getPosts(page)
        }
    },
    mounted() {
        this.getPosts()
    }
}
</script>

<style scoped>

</style>
