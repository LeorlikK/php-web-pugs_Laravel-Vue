<template>
    <MediaMenu></MediaMenu>
    <div class="container-media">
        <h3 class="content-title">Audio</h3>
        <div class="content content-audio">
            <div v-for="post in posts" class="audio">
                <div>
                    <audio
                        :volume="volume"
                        @input="updateVolume"
                        controls :src="`/storage${post.url}`" preload="metadata"></audio>
                </div>
                <p>{{ post.name }}</p>
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
import Paginator from "@/Components/Paginator.vue";
import {API_ROUTES} from "@/routs";
import axiosAuthUser from "@/axiosAuthUser";
import BigSize from "@/Media/BigSize.vue";
import router from "@/router";
import MediaMenu from "@/Components/Menu/MediaMenu.vue";
import cookiesMixin from "@/mixins/authMixin";
import logMixin from "@/mixins/logMixin";

export default {
    name: "Audio",
    components: {MediaMenu, BigSize, Paginator},
    mixins: [cookiesMixin, logMixin],
    data() {
        return {
            showImage: false,
            posts: [],
            pagination: {
                current_page: 1,
                last_page: null,
                total: null,
            },
            volume: this.getCookie('audio-volume') ?? 1
        }
    },
    methods: {
        getPosts(page){
            this.pagination.current_page = page
            axiosAuthUser.get(`${API_ROUTES.public.audio}`, {
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
        updateVolume(event) {
            let currentDate = new Date();
            let currentYear = currentDate.getFullYear()
            currentDate.setMonth(currentYear + 1)
            document.cookie = `audio-volume=${event.target.volume}; expires=${currentDate.toUTCString()}`
        }
    },
    mounted() {
        this.getPosts()
    }
}
</script>

<style scoped>

</style>
