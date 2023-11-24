<template>
    <MediaMenu
        photo_route="photos"
        video_route="video"
        audio_route="audio"
    ></MediaMenu>
    <div class="container-media">
        <h3 class="content-title">Photos</h3>
        <div :class="items.length > 3 ? 'counter-items-4' : 'counter-items-3'" class="content content-media">
            <div v-for="item in items" class="photo">
                <div>
<!--                    <img @click.prevent="changeShowImage(this.path + item.url)" class="image photo-img" :src="this.path + item.url" alt="#">-->
                    <img @click.prevent="changeShowImage(this.path + item.url)" class="image photo-img" src="" alt="#">
                </div>
                <p>{{ item.name }}</p>
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
import fileMixin from "@/mixins/fileMixin";
import logMixin from "@/mixins/logMixin";
import paginationMixin from "@/mixins/paginationMixin";
export default {
    name: "Photo",
    components: {MediaMenu, BigSize, Paginator},
    mixins: [fileMixin, logMixin, paginationMixin],
    data() {
        return {
            items: [],
        }
    },
    methods: {
        getItems(page){
            this.assigningCurrentPage(page)
            router.replace({ query: {page: page} })
            myAxios.get(`${API_ROUTES.public.photo}`, {
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
