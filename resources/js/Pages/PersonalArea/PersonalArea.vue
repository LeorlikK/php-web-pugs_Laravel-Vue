<template>
    <div class="content">
        <div class="personal-area">
            <div class="personal-email">
                <div class="text">
                    <p class="static">Email:</p>
                    <input
                        disabled
                        :value="email"
                        class="value input-unactive">
                </div>
            </div>
            <div class="personal-login">
                <div class="text">
                    <p class="static">Login:</p>
                    <input
                        :disabled="update"
                        v-model="login"
                        :class="update ? 'input-unactive' : 'input-active'" class="value">
                </div>
                <p v-if="this.errors.loginError" class="error-message">{{ this.errors.loginError[0] }}</p>
            </div>

            <div class="personal-avatar">
                <div class="text">
                    <p class="static">Avatar:</p>
                </div>
                <div v-if="!update" class="img-file">
                    <input
                        @change="changeImage"
                        type="file" class="img-file-input" id="examplePhotos" accept="image/*,.png,.jpg">
                    <div
                        :class="this.file?.name ? 'btn-active' : 'btn-cancel'"
                        class="img-file-label">
                        <label  for="examplePhotos">Выберите изображение:</label>
                    </div>
                    <p class="img-file-info">{{ this.file?.name ?? ''}}</p>
                </div>
                <p v-if="this.errors.loginError" class="error-message">{{ this.errors.loginError[0] }}</p>

                <div class="block-img">
                    <img :src="this.avatar" alt="#" class="photo-img">
                </div>
            </div>
            <div class="update">
                <a
                    v-if="!update"
                    @click.prevent="save"
                    class="btn btn-update btn-active">Сохранить
                </a>
                <a
                    v-if="update"
                    @click.prevent="btnUpdate"
                    class="btn btn-update">Обновить
                </a>
                <a
                    v-if="!update"
                    @click.prevent="cancel"
                    class="btn btn-update btn-cancel">Отмена
                </a>
            </div>
        </div>
    </div>
</template>

<script>
import axiosAuthUser from "@/axiosAuthUser";
import {API_ROUTES} from "@/routs";
import inputErrorsMixin from "@/mixins/inputErrorsMixin";
import errorsLogMixin from "@/mixins/errorsLogMixin";
import cookiesMixin from "@/mixins/authMixin";

export default {
    name: "PersonalArea",
    mixins: [inputErrorsMixin, errorsLogMixin],
    data() {
        return {
            email: null,

            oldLogin: null,
            login: null,

            path: '/storage',
            oldAvatar: null,
            avatar: null,
            file: null,

            update: true,
            errors: {
                loginError: '',
                avatarError: '',
            },
        }
    },
    methods: {
        getMe(){
            axiosAuthUser.get(`${API_ROUTES.protected.me}`)
                .then(data => {
                    this.email = data.data.user.email
                    this.login = data.data.user.login
                    this.avatar = this.path + data.data.user.avatar
                })
                .catch(errors => {
                    console.log(errors)
                })
        },
        btnUpdate() {
            this.oldLogin = this.login
            this.update = false
        },
        cancel() {
            this.login = this.oldLogin
            if (this.oldAvatar) this.avatar = this.oldAvatar
            this.file = null
            this.errors.loginError = null
            this.errors.avatarError = null
            this.update = true
        },
        changeImage(event) {
            this.file = event.target.files[0]
            this.oldAvatar = this.avatar
            if (this.file) {
                this.avatar = URL.createObjectURL(this.file);
            }
        },
        save() {
            this.errors.loginError = null
            this.errors.avatarError = null
            const formData = new FormData()
            formData.append('login', this.login)
            if (this.file) {
                formData.append('avatar', this.file)
            }

            axiosAuthUser.post(`${API_ROUTES.protected.updateMe}`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            })
                .then(data => {
                    this.email = data.data.user.email
                    this.login = data.data.user.login
                    this.avatar = this.path + data.data.user.avatar
                    this.update = true
                })
                .catch(errors => {
                    this.errorsLog(errors)
                    if (errors.response.status === 422) this.saveError(errors)
                })
        }
    },
    mounted() {
        this.getMe()
    }
}
</script>

<style scoped>

</style>
