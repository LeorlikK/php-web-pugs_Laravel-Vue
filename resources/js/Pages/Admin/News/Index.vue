<template>
    <div class="container-admin">
        <AdminMenu></AdminMenu>
        <div class="content content-admin-users">
            <div class="users">
                <div class="update margin-20">
                    <router-link class="btn btn-update btn-white-c" :to="{name: 'admin_news_create'}">Создать</router-link>
                </div>
                <table class="admin-table">
                    <thead>
                    <tr>
                        <th scope="row">ID</th>
                        <th>User</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Short</th>
                        <th>Text</th>
                        <th>Publish</th>
                        <th>Created_At</th>
                        <th>Updated_At</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in items" :class="!item.publish ? 'banned-line' : ''" :key="item.id">
                        <th>{{ item.id }}</th>
                        <td>{{ item.user }}</td>
                        <td>
                            <img @click.prevent="changeShowImage(this.path + item.image_url)" :src="this.path + item.image_url" alt="#" class="table-img">
                        </td>
                        <td>{{ item.title }}</td>
                        <td>{{ item.short }}</td>
                        <td>{{ item.text }}</td>
                        <td :class="item.publish ? 'users-btn-update' : 'users-btn-banned'">
                            <a @click.prevent="confirm(item, item.publish ? 'Убрать публикацию?' : 'Опубликовать?')">
                                {{ item.publish ? 'Publish' : 'Hidden'}}
                            </a>
                        </td>
                        <td>{{ item.created_at }}</td>
                        <td>{{ item.updated_at }}</td>
                        <td class="users-btn-update"><router-link :to="{name: 'admin_news_edit', params: {news: item.id}}">Update</router-link></td>
                        <td class="users-btn-banned">
                            <a @click.prevent="confirm(item, 'Удалить новость?')">Delete</a>
                        </td>

                    </tr>
                    </tbody>
                </table>
            </div>
            <Paginator
                v-if="pagination.last_page > 1"
                :current_page="pagination.current_page"
                :last_page="pagination.last_page"
                :total="pagination.total"
                @changePage="changePage"
            ></Paginator>
            <Confirm
                :text="textConfirm"
                :question="question"
                @answer="deleteOrPublish"
            ></Confirm>
            <BigSize
                @changeShowImage="changeShowImage"
                :showImage="showImage"
            ></BigSize>
        </div>
    </div>
</template>


<script>
import AdminMenu from "@/Components/Menu/AdminMenu.vue";
import MediaMenu from "@/Components/Menu/MediaMenu.vue";
import BigSize from "@/Media/BigSize.vue";
import Confirm from "@/Components/Сonfirmation/Confirm.vue";
import InputImage from "@/Components/Inputs/InputImage.vue";
import inputErrorsMixin from "@/mixins/inputErrorsMixin";
import errorsLogMixin from "@/mixins/logMixin";
import fileMixin from "@/mixins/fileMixin";
import confirmMixin from "@/mixins/confirmMixin";
import paginationMixin from "@/mixins/paginationMixin";
import router from "@/router";
import myAxios from "@/myAxios";
import {API_ROUTES} from "@/routs";

export default {
    name: "Index",
    components: {AdminMenu, MediaMenu, BigSize, Confirm},
    mixins: [inputErrorsMixin, errorsLogMixin, fileMixin, InputImage, confirmMixin, paginationMixin],
    data() {
        return {
            items: [],
            delete: ''
        }
    },
    methods: {
        getItems(page) {
            this.assigningCurrentPage(page)
            router.replace({ query: {page: page} })
            myAxios.get(`${API_ROUTES.protected.admin_news}`, { params: {page: page} })
                .then(data => {
                    console.log(data)
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
        changePublish(confirm) {
            this.question = false
            if (confirm){
                myAxios.post(`${API_ROUTES.protected.admin_news_publish}/${this.objQuestion.id}`)
                    .then(data => {
                        console.log(data)
                        this.dataLog(data)
                        this.objQuestion.publish = !this.objQuestion.publish
                        this.objQuestion = null
                    })
                    .catch(errors => {
                        this.errorsLog(errors)
                    })
            } else {
                this.objQuestion = null
            }
        },
        deleteNews(confirm) {
            this.question = false
            if (confirm){
                myAxios.delete(`${API_ROUTES.protected.admin_news_delete}/${this.objQuestion.id}`)
                    .then(data => {
                        this.dataLog(data)
                        this.items = this.items.filter(c => c.id !== this.objQuestion.id);
                        this.objQuestion = null
                    })
                    .catch(errors => {
                        this.errorsLog(errors)
                    })
            } else {
                this.objQuestion = null
            }
        },
        deleteOrPublish(confirm, text) {
            this.question = false
            if (confirm){
                text === 'Удалить новость?' ? this.deleteNews(confirm) : this.changePublish(confirm)
            } else {
                this.objQuestion = null
            }
        }
    },
    mounted() {
        this.getItems(this.pagination.current_page)
    }
}
</script>

<style scoped>

</style>
