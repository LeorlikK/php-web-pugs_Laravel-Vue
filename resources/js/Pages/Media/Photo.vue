<template>
    <MediaMenu></MediaMenu>
    <div class="container-media">
        <h3 class="content-title">Photos</h3>
        <div :class="posts.length > 3 ? 'counter-items-4' : 'counter-items-3'" class="content content-media">
            <div v-for="post in posts" class="photo">
                <div>
                    <img @click.prevent="changeShowImage(post.url)" class="image photo-img" :src="`/storage${post.url}`" alt="#">
                </div>
                <p>{{ post.name }}</p>
            </div>
        </div>
        <BigSize
            @changeShowImage="changeShowImage"
            :showImage="showImage"
        ></BigSize>
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
import Paginator from "@/Components/Paginator.vue";
import {API_ROUTES} from "@/routs";
import myAxios from "@/myAxios";
import BigSize from "@/Media/BigSize.vue";
import router from "@/router";
import MediaMenu from "@/Components/Menu/MediaMenu.vue";
import imageMixin from "@/mixins/imageMixin";
import logMixin from "@/mixins/logMixin";
export default {
    name: "Photo",
    components: {MediaMenu, BigSize, Paginator},
    mixins: [imageMixin, logMixin],
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
            myAxios.get(`${API_ROUTES.public.photos}`, {
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
        }
    },
    mounted() {
        this.getPosts()
    }
}
</script>

<style scoped>

</style>
