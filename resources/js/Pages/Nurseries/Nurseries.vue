<template>
    <div class="container-nurseries">
        <h3 class="content-title">Питомники мопсов</h3>
        <div class="content content-nurseries">
            <div v-if="items" v-for="item in items" class="nurseries" :key="item">
                <h1>{{item.title}}</h1>
                <div class="image">
                    <img class="image" :src="this.path + item.image_url" alt="#">
                </div>
                <p>{{item.text}}</p>
                <div class="contact-info">
                    <button class="btn">
                        <a :href="'tel:' + item.phone">Позвонить</a>
                    </button>

                    <button class="btn">
                        <a :href=item.address target="_blank">Сайт</a>
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
import myAxios from "@/myAxios";
import {API_ROUTES} from "@/routs";
import Paginator from "@/Components/Paginator.vue";
import router from "@/router";
import inputErrorsMixin from "@/mixins/inputErrorsMixin";
import logMixin from "@/mixins/logMixin";
import fileMixin from "@/mixins/fileMixin";
import paginationMixin from "@/mixins/paginationMixin";

export default {
    name: "Nurseries",
    components: {Paginator},
    mixins: [fileMixin, logMixin, paginationMixin],
    data(){
        return {
            items: [],
        }
    },
    methods: {
        getItems(page) {
            this.assigningCurrentPage(page)
            myAxios.get(`${API_ROUTES.public.nurseries}`, {
                params: {
                    page: this.page
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
