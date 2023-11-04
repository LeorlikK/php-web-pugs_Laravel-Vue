<template>
    <div class="category-menu media-menu">
        <ul>
            <li><router-link :to="{name:'peculiarities_care'}">Photos</router-link></li>
            <li><router-link :to="{name:'peculiarities_nutrition'}">Video</router-link></li>
            <li><router-link :to="{name:'peculiarities_health'}">Audio</router-link></li>
        </ul>
    </div>
    <h3 class="content-title">Photos</h3>
    <div class="content">
        <div class="media">
            <div></div>
        </div>
    </div>
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
export default {
    name: "Photo",
    components: {Paginator},
    data() {
        return {
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
    },
    mounted() {
        this.getPosts()
    }
}
</script>

<style scoped>

</style>
