<template>
    <div class="container-admin">
        <AdminMenu></AdminMenu>
        <MediaMenu
            photo_route="admin_photo"
            video_route="admin_video"
            audio_route="admin_audio"
        ></MediaMenu>
        <div class="content content-admin-media">
            <div class="users">
                <InputImage
                    :process="process"
                    :percent="percent"
                    :file="this.fileImage"
                    @changeImage="changeImage"
                ></InputImage>
                <p v-if="this.errors.imageError" class="error-message">{{ this.errors.imageError[0] }}</p>
                <div class="update margin-20">
                    <a
                        @click.prevent="loadImage"
                        :class="imageBtnIsActive ? 'btn-active' : 'btn-block'"
                        class="btn btn-update btn-white-c">Добавить</a>
                </div>
                <table class="admin-table">
                    <thead>
                    <tr>
                        <th scope="row">ID</th>
                        <th>Image</th>
                        <th>Url</th>
                        <th>Name</th>
                        <th>Size</th>
                        <th>Created_At</th>
                        <th>Updated_At</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in items" :class="item.banned ? 'banned-line' : ''" :key="item.id">
                        <th>{{ item.id }}</th>
                        <td>
                            <img @click.prevent="changeShowImage(this.path + item.url)" :src="this.path + item.url" alt="#" class="table-img">
                        </td>
                        <td>{{ item.url }}</td>
                        <td>{{ item.name }}</td>
                        <td>{{ item.size }}</td>
                        <td>{{ item.created_at }}</td>
                        <td>{{ item.updated_at }}</td>
                        <td class="users-btn-update"><router-link :to="{name: 'admin_photo_edit', params: {photo: item.id}}">Update</router-link></td>
                        <td class="users-btn-banned">
                            <a @click.prevent="confirm(item, 'Удалить изображение?')">Delete</a>
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
                @answer="deleteImage"
            ></Confirm>
            <BigSize
                @changeShowImage="changeShowImage"
                :showImage="showImage"
            ></BigSize>
        </div>
    </div>
</template>

<script>
import MediaMenu from "@/Components/Menu/MediaMenu.vue";
import AdminMenu from "@/Components/Menu/AdminMenu.vue";
import inputErrorsMixin from "@/mixins/inputErrorsMixin";
import errorsLogMixin from "@/mixins/logMixin";
import router from "@/router";
import myAxios from "@/myAxios";
import {API_ROUTES} from "@/routs";
import BigSize from "@/Media/BigSize.vue";
import Confirm from "@/Components/Сonfirmation/Confirm.vue";
import InputImage from "@/Components/Inputs/InputImage.vue";
import fileMixin from "@/mixins/fileMixin";
import confirmMixin from "@/mixins/confirmMixin";
import paginationMixin from "@/mixins/paginationMixin";
export default {
    name: "Photos",
    components: {AdminMenu, MediaMenu, BigSize, Confirm, InputImage},
    mixins: [inputErrorsMixin, errorsLogMixin, fileMixin, confirmMixin, paginationMixin],
    data() {
        return {
            items: [],
        }
    },
    methods: {
        getItems(page) {
            this.assigningCurrentPage(page)
            router.replace({ query: {page: page} })
            myAxios.get(`${API_ROUTES.public.photo}`, { params: {page: page} })
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
        loadImage() {
            if (this.fileImage) {
                this.clearErrors()
                this.process = true
                const formData = new FormData()
                formData.append('image', this.fileImage)
                myAxios.post(`${API_ROUTES.protected.admin_photo_store}`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                    onUploadProgress: progressEvent => {
                        this.percent = Math.round((progressEvent.loaded * 100) / progressEvent.total)
                    }
                })
                    .then(data => {
                        this.dataLog(data)
                        this.items.unshift(data.data.data)
                        this.fileImage = null
                        this.process = false
                        this.percent = 0
                    })
                    .catch(errors => {
                        this.errorsLog(errors)
                        if (errors.response.status === 422) this.saveError(errors)
                        this.process = false
                        this.percent = 0
                    })
            }
        },
        deleteImage(confirm) {
            this.question = false
            if (confirm){
                myAxios.delete(`${API_ROUTES.protected.admin_photo_delete}/${this.objQuestion.id}`)
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
    },
    mounted() {
        this.getItems(this.pagination.current_page)
    }
}
</script>

<style scoped>

</style>
