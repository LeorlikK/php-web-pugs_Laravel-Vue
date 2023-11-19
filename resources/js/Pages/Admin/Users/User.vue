<template>
    <div class="container-admin">
        <AdminMenu></AdminMenu>
        <div class="content content-admin-users">
            <div class="user">
                <div class="item">
                    <div class="text text-user size-12">
                        <p class="static">ID:</p>
                        <input
                            disabled
                            :value="id"
                            class="value input-unactive size-12">
                    </div>
                </div>
                <div class="item">
                    <div class="text text-user">
                        <p class="static">Email:</p>
                        <input
                            :disabled="update"
                            v-model="email"
                            :class="update ? 'input-unactive' : 'input-active'" class="value size-12">
                    </div>
                    <div class="text-user">
                        <p v-if="this.errors.emailError" class="error-message text-left">{{ this.errors.emailError[0] }}</p>
                    </div>
                </div>
                <div class="item">
                    <div class="text text-user">
                        <p class="static">Login:</p>
                        <input
                            :disabled="update"
                            v-model="login"
                            :class="update ? 'input-unactive' : 'input-active'" class="value size-12">
                    </div>
                    <div class="text-user">
                        <p v-if="this.errors.loginError" class="error-message text-left">{{ this.errors.loginError[0] }}</p>
                    </div>
                </div>
                <div class="item">
                    <div class="text text-user">
                        <p class="static">Role:</p>
                        <select :disabled="update" v-model="role" :class="update ? '' : 'select-active'">
                            <option :selected="role === 'admin'" value="admin">Admin</option>
                            <option :selected="role === 'user'" value="user">User</option>
                            <option :selected="role === 'moder'" value="moder">Moder</option>
                        </select>
                    </div>
                    <div class="text-user">
                        <p v-if="this.errors.roleError" class="error-message text-left">{{ this.errors.roleError[0] }}</p>
                    </div>
                </div>
                <div class="item item-image">
                    <div class="text text-user">
                        <p class="static">Avatar:</p>
                        <div class="block-img" :class="update ? '' : 'img-active'">
                            <img @click.prevent="changeShowImage(this.avatar)" :src="this.avatar" alt="#" class="photo-img">
                        </div>
                    </div>
                    <div class="text-user">
                        <p v-if="this.errors.avatarError" class="error-message text-left">{{ this.errors.avatarError[0] }}</p>
                    </div>
                </div>
                <div v-if="!update" class="item">
                    <div class="text text-user">
                        <p class="static"></p>
                        <div class="img-file">
                            <input
                                @change="changeImage"
                                type="file" class="img-file-input" id="examplePhotos" accept="image/*,.png,.jpg">
                            <div
                                :class="this.file?.name ? 'btn-active' : 'btn-cancel'"
                                class="img-file-label">
                                <label  for="examplePhotos">Выберите изображение:</label>
                            </div>
                            <p class="img-file-info">{{ this.file?.name ?? 'Файл не выбран'}}</p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="text text-user">
                        <p class="static">Banned:</p>
                        <input v-model="banned"
                               :disabled="update"
                               :value="banned"
                               :class="update ? '' : 'checkbox-active'" class="checkbox"
                               type="checkbox">
                    </div>
                    <div class="text-user">
                        <p v-if="this.errors.loginError" class="error-message text-left">{{ this.errors.loginError[0] }}</p>
                    </div>
                </div>
                <div class="item">
                    <div class="text text-user">
                        <p class="static">Created At:</p>
                        <input
                            disabled
                            :value="created_at"
                            class="value input-unactive size-12">
                    </div>
                </div>
                <div class="item">
                    <div class="text text-user">
                        <p class="static">Updated At:</p>
                        <input
                            disabled
                            :value="updated_at"
                            class="value input-unactive size-12">
                    </div>
                </div>
                <div class="update">
                    <a
                        v-if="!update"
                        @click.prevent="save"
                        class="btn btn-update btn-active btn-white-c">Сохранить
                    </a>
                    <a
                        v-if="update"
                        @click.prevent="btnUpdate"
                        class="btn btn-update btn-white-c">Изменить
                    </a>
                    <a
                        v-if="!update"
                        @click.prevent="cancel"
                        class="btn btn-update btn-cancel btn-white-c">Отмена
                    </a>
                </div>
            </div>
        </div>
        <BigSize
            @changeShowImage="changeShowImage"
            :showImage="showImage"
        ></BigSize>
    </div>
</template>

<script>
import AdminMenu from "@/Components/Menu/AdminMenu.vue";
import BigSize from "@/Media/BigSize.vue";
import router from "@/router";
import myAxios from "@/myAxios";
import {API_ROUTES} from "@/routs";
import inputErrorsMixin from "@/mixins/inputErrorsMixin";
import logMixin from "@/mixins/logMixin";
import imageMixin from "@/mixins/imageMixin";
export default {
    name: "User",
    components: {AdminMenu, BigSize},
    mixins: [inputErrorsMixin, logMixin, imageMixin],
    data() {
        return {
            user_id: router.currentRoute.value.params.user,
            update: true,
            path: '/storage',
            file: null,
            showImage: false,

            id: null,
            email: null,
            login: null,
            role: null,
            avatar: null,
            banned: null,
            created_at: null,
            updated_at: null,

            oldEmail: '',
            oldLogin: '',
            oldRole: '',
            oldAvatar: '',
        }
    },
    methods: {
        getUser() {
            myAxios.get(`${API_ROUTES.protected.admin_user_edit}/${this.user_id}`)
                .then(data => {
                    this.dataLog(data)
                    data = data.data.data
                    this.id = data.id
                    this.email = data.email
                    this.login = data.login
                    this.role = data.role
                    this.avatar = this.path + data.avatar
                    this.oldAvatar = this.path + data.avatar
                    this.banned = Boolean(data.banned)
                    this.created_at = data.created_at
                    this.updated_at = data.updated_at
                })
                .catch(errors => {
                    this.errorsLog(errors)
                })
        },
        save() {
            this.errors.loginError = null
            this.errors.avatarError = null
            const formData = new FormData()
            formData.append('id', this.id)
            formData.append('email', this.email)
            formData.append('login', this.login)
            formData.append('role', this.role)
            formData.append('banned', this.banned)
            if (this.file) {
                formData.append('avatar', this.file)
            }

            myAxios.post(`${API_ROUTES.protected.admin_user_update}/${this.id}`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            })
                .then(data => {
                    this.dataLog(data)
                    data = data.data.data
                    this.id = data.id
                    this.email = data.email
                    this.login = data.login
                    this.role = data.role
                    this.avatar = this.path + data.avatar
                    this.oldAvatar = this.path + data.avatar
                    this.created_at = data.created_at
                    this.updated_at = data.updated_at
                    this.file = null
                    this.update = true
                })
                .catch(errors => {
                    this.errorsLog(errors)
                    if (errors.response.status === 422) this.saveError(errors)
                })
        },
        btnUpdate() {
            this.oldEmail = this.email
            this.oldLogin = this.login
            this.oldRole = this.role
            this.update = false
        },
        cancel() {
            this.email = this.oldEmail
            this.login = this.oldLogin
            this.role = this.oldRole
            this.avatar = this.oldAvatar
            this.errors.loginError = null
            this.errors.avatarError = null
            this.file = null
            this.update = true
        },
    },
    mounted() {
        this.getUser()
    }
}
</script>

<style scoped>

</style>
