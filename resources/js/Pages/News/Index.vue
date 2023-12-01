<template>
    <div class="container-news">
        <h3 class="content-title">Новости</h3>
        <div class="content content-news">
            <div class="news">
                <div v-if="items" v-for="item in items">
                    <h1>
                        <router-link :to="{name: 'news_show', params: {news: item.id}, query: {page: pagination.current_page}}">
                            {{item.title}}
                        </router-link>
                    </h1><hr>
                    <div class="image">
                        <img class="image" :src="this.path + item.image_url" alt="#">
                    </div><hr>
                    <div>
                        <h2>{{ item.short }}</h2>
                    </div><hr>
                    <div class="news-footer">
                        <p>Автор: {{item.user}}</p>
                        <p>Дата публикации: {{ item.created_at }}</p>
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
import logMixin from "@/mixins/logMixin";
import fileMixin from "@/mixins/fileMixin";
import paginationMixin from "@/mixins/paginationMixin";

export default {
    name: "Index",
    components: {Paginator},
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
            myAxios.get(`${API_ROUTES.public.news}`, {
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
