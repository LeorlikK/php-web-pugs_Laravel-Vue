<!--<template>-->
<!--    <div class="container-admin">-->
<!--        <AdminMenu></AdminMenu>-->
<!--        <MediaMenu-->
<!--            photo_route="admin_photos"-->
<!--            video_route="admin_video"-->
<!--            audio_route="admin_audio"-->
<!--        ></MediaMenu>-->
<!--        <div class="content content-admin-media">-->
<!--            <div class="users">-->
<!--                <InputVideo-->
<!--                    :file="this.file"-->
<!--                    @changeImage="changeImage"-->
<!--                ></InputVideo>-->
<!--                <p v-if="this.errors.avatarError" class="error-message">{{ this.errors.avatarError[0] }}</p>-->
<!--                <div class="update margin-20">-->
<!--                    <a-->
<!--                        @click.prevent="loadImage"-->
<!--                        :class="btnIsActive ? 'btn-active' : 'btn-block'"-->
<!--                        class="btn btn-update btn-white-c">Добавить</a>-->
<!--                </div>-->
<!--                <table class="admin-table">-->
<!--                    <thead>-->
<!--                    <tr>-->
<!--                        <th scope="row">ID</th>-->
<!--                        <th>Image</th>-->
<!--                        <th>Url</th>-->
<!--                        <th>Name</th>-->
<!--                        <th>Size</th>-->
<!--                        <th>Created_At</th>-->
<!--                        <th>Updated_At</th>-->
<!--                        <th></th>-->
<!--                        <th></th>-->
<!--                    </tr>-->
<!--                    </thead>-->
<!--                    <tbody>-->
<!--                    <tr v-for="post in posts" :class="post.banned ? 'banned-line' : ''" :key="post.id">-->
<!--                        <th>{{ post.id }}</th>-->
<!--                        <td>-->
<!--                            <video-->
<!--                                :volume="volume"-->
<!--                                @input="updateVolume"-->
<!--                                controls class="table-video">-->
<!--                                <source :src="`/storage${post.url}`" type="video/mp4">-->
<!--                            </video>-->
<!--                        </td>-->
<!--                        <td>{{ post.url }}</td>-->
<!--                        <td>{{ post.name }}</td>-->
<!--                        <td>{{ post.size }}</td>-->
<!--                        <td>{{ post.created_at }}</td>-->
<!--                        <td>{{ post.updated_at }}</td>-->
<!--                        <td class="users-btn-update"><router-link :to="{name: 'admin_user_edit', params: {user: post.id}}">Update</router-link></td>-->
<!--                        <td class="users-btn-banned">-->
<!--                            <a @click.prevent="confirmDelete(post)">Delete</a>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    </tbody>-->
<!--                </table>-->
<!--            </div>-->
<!--            <Paginator-->
<!--                v-if="pagination.last_page > 1"-->
<!--                :current_page="pagination.current_page"-->
<!--                :last_page="pagination.last_page"-->
<!--                :total="pagination.total"-->
<!--                @changePage="changePage"-->
<!--            ></Paginator>-->
<!--            <Confirm-->
<!--                :text="textBannedUser"-->
<!--                :question="question"-->
<!--                @answer="deleteImage"-->
<!--            ></Confirm>-->
<!--        </div>-->
<!--    </div>-->
<!--</template>-->

<!--<script>-->
<!--import AdminMenu from "@/Components/Menu/AdminMenu.vue";-->
<!--import MediaMenu from "@/Components/Menu/MediaMenu.vue";-->
<!--import Confirm from "@/Components/Сonfirmation/Confirm.vue";-->
<!--import router from "@/router";-->
<!--import inputErrorsMixin from "@/mixins/inputErrorsMixin";-->
<!--import errorsLogMixin from "@/mixins/logMixin";-->
<!--import imageMixin from "@/mixins/imageMixin";-->
<!--import myAxios from "@/myAxios";-->
<!--import {API_ROUTES} from "@/routs";-->
<!--import InputVideo from "@/Components/Inputs/InputVideo.vue";-->

<!--export default {-->
<!--    name: "Video",-->
<!--    components: {AdminMenu, MediaMenu, Confirm, InputVideo},-->
<!--    mixins: [inputErrorsMixin, errorsLogMixin, imageMixin],-->
<!--    data() {-->
<!--        return {-->
<!--            posts: [],-->
<!--            pagination: {-->
<!--                current_page: router.currentRoute.value.query.page,-->
<!--                last_page: null,-->
<!--                total: null,-->
<!--            },-->
<!--            path: '/storage',-->
<!--            avatar: null,-->
<!--            oldAvatar: null,-->
<!--            file: null,-->
<!--            showImage: false,-->

<!--            textBannedUser: '',-->
<!--            question: false,-->
<!--            imageForDelete: null-->
<!--        }-->
<!--    },-->
<!--    methods: {-->
<!--        getVideo(page) {-->
<!--            this.pagination.current_page = page-->
<!--            router.replace({ query: {page: page} })-->
<!--            myAxios.get(`${API_ROUTES.public.video}`, { params: {page: page} })-->
<!--                .then(data => {-->
<!--                    this.dataLog(data)-->
<!--                    data = data.data-->
<!--                    this.posts.splice(0)-->
<!--                    this.posts.push(...data.data)-->
<!--                    this.pagination.current_page = data.meta.current_page-->
<!--                    this.pagination.last_page = data.meta.last_page-->
<!--                    this.pagination.total = data.meta.total-->
<!--                })-->
<!--                .catch(errors => {-->
<!--                    this.errorsLog(errors)-->
<!--                })-->
<!--        }-->
<!--    },-->
<!--    mounted() {-->
<!--        this.getVideo(this.pagination.current_page)-->
<!--    }-->
<!--}-->
<!--</script>-->

<!--<style scoped>-->

<!--</style>-->
