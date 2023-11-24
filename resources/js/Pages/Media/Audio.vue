<template>
    <MediaMenu
        photo_route="photos"
        video_route="video"
        audio_route="audio"
    ></MediaMenu>
    <div class="container-media">
        <h3 class="content-title">Audio</h3>
        <div class="content content-audio">
            <div v-for="item in items" class="audio">
                <AudioPlayer
                    :src="this.path + item.url"
                ></AudioPlayer>
<!--                <div>-->
<!--                    <audio-->
<!--                        :volume="volume"-->
<!--                        @input="audioUpdateVolume"-->
<!--                        controls :src="this.path + item.url" preload="metadata"></audio>-->
<!--                </div>-->
<!--                <p>{{ item.name }}</p>-->
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
import myAxios from "@/myAxios";
import BigSize from "@/Media/BigSize.vue";
import router from "@/router";
import MediaMenu from "@/Components/Menu/MediaMenu.vue";
import cookieService from '@/services/cookieService.js'
import logMixin from "@/mixins/logMixin";
import fileMixin from "@/mixins/fileMixin";
import paginationMixin from "@/mixins/paginationMixin";
import AudioPlayer from "@/Components/Players/AudioPlayer.vue";

export default {
    name: "Audio",
    components: {MediaMenu, BigSize, Paginator, AudioPlayer},
    mixins: [fileMixin, logMixin, paginationMixin],
    data() {
        return {
            items: [],
            volume: cookieService.getCookie('audio-volume') ?? 1
        }
    },
    methods: {
        getItems(page){
            this.assigningCurrentPage(page)
            router.replace({ query: {page: page} })
            myAxios.get(`${API_ROUTES.public.audio}`, {
                params: {
                    page: this.pagination.current_page
                },
            })
                .then(data => {
                    this.dataLog(data)
                    data = data.data
                    this.items.splice(0)
                    this.items.push(...data.data)
                    this.assigningValuesPaginator(data)
                })
                .catch(errors => {
                    this.errorsLog(errors)
                })
        },
    },
    mounted() {
        this.getItems(this.pagination.current_page)
    }
}
</script>

<style scoped>

</style>
