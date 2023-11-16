<template>
    <MediaMenu></MediaMenu>
    <div class="container-media">
        <h3 class="content-title">Video</h3>
        <div :class="posts.length > 3 ? 'counter-items-4' : 'counter-items-3'" class="content content-media">
            <div v-for="post in posts" class="photo">
                <div>
                    <video
                        :volume="volume"
                        @input="updateVolume"
                        controls class="image video-img">
                        <source :src="`/storage${post.url}`" type="video/mp4">
                    </video>
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
import MediaMenu from "@/Components/Menu/MediaMenu.vue";
import BigSize from "@/Media/BigSize.vue";
import Paginator from "@/Components/Paginator.vue";
import router from "@/router";
import axiosAuthUser from "@/axiosAuthUser";
import {API_ROUTES} from "@/routs";
import cookiesMixin from "@/mixins/authMixin";
import logMixin from "@/mixins/logMixin";
export default {
    name: "Video",
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
            volume: this.getCookie('video-volume') ?? 1
        }
    },
    methods: {
        getPosts(page){
            this.pagination.current_page = page
            axiosAuthUser.get(`${API_ROUTES.public.video}`, {
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
            document.cookie = `video-volume=${event.target.volume}; expires=${currentDate.toUTCString()}`
        }
    },
    mounted() {
        this.getPosts()
    }
}
</script>

<style scoped>

</style>
