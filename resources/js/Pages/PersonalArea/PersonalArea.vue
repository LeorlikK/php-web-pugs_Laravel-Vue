<template>
    <div class="container-personal-area">
        <div class="content content-personal-area">
            <div class="personal-email">
                <div class="text">
                    <p class="static size-15">Email:</p>
                    <input
                        disabled
                        :value="email"
                        class="value input-unactive size-12">
                </div>
            </div>
            <div class="personal-role">
                <div class="text">
                    <p class="static size-15">Role:</p>
                    <input
                        disabled
                        :value="role"
                        class="value input-unactive size-12">
                </div>
            </div>
            <div class="personal-login">
                <div class="text">
                    <p class="static size-15">Login:</p>
                    <input
                        :disabled="update"
                        v-model="login"
                        :class="update ? 'input-unactive' : 'input-active'" class="value size-12">
                </div>
                <div class="personal-error">
                    <p v-if="this.errors.loginError" class="error-message">{{ this.errors.loginError[0] }}</p>
                </div>
            </div>
            <div class="personal-avatar">
                <div class="text">
                    <p class="static size-15">Avatar:</p>
                    <InputImage
                        v-if="!update"
                        :process="process"
                        :percent="percent"
                        :file="this.fileImage"
                        @changeImage="changeImage"
                    ></InputImage>
                </div>
                <div class="personal-error">
                    <p v-if="this.errors.avatarError" class="error-message">{{ this.errors.avatarError[0] }}</p>
                </div>
            </div>
            <div class="personal-img">
                <div class="text text-user">
                    <p class="static"></p>
                    <div class="block-img" :class="update ? '' : 'img-active'">
                        <img @click.prevent="changeShowImage(this.image ?? this.avatar)" :src="this.image ?? this.avatar" alt="#" class="photo-img">
                    </div>
                </div>
            </div>
            <div class="personal-banned">
                <div class="text">
                    <p class="static size-15">Role:</p>
                    <input
                        disabled
                        :value="banned ? 'Banned' : 'Active'"
                        :class="banned ? 'color-unactive' : 'color-active'" class="value input-unactive size-12">
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
                        class="btn btn-update">Изменить
                    </a>
                    <a
                        v-if="!update"
                        @click.prevent="cancel"
                        class="btn btn-update btn-cancel">Отмена
                    </a>
        </div>
            <div class="personal-feedback">
                <div class="text-feedback">
                    <p class="static size-15">Feedback:</p>
                    <textarea v-model="feedback" class="textarea-users" placeholder="Leave a review..."></textarea>
                </div>
                <div class="personal-error">
                    <p v-if="this.errors.feedbackError" class="error-message" style="grid-column: 1/5">{{ this.errors.feedbackError[0] }}</p>
                </div>
            </div>
            <div class="send-feedback">
                <a
                    aria-disabled="true"
                    @click.prevent="sendFeedback"
                    class="btn btn-update" style="margin-right: 0">Отправить
                </a>
            </div>
        </div>
        <BigSize
            @changeShowImage="changeShowImage"
            :showImage="showImage"
        ></BigSize>
    </div>
</template>

<script>
import myAxios from "@/myAxios";
import {API_ROUTES} from "@/routs";
import inputErrorsMixin from "@/mixins/inputErrorsMixin";
import logMixin from "@/mixins/logMixin";
import BigSize from "@/Media/BigSize.vue";
import fileMixin from "@/mixins/fileMixin";
import InputImage from "@/Components/Inputs/InputImage.vue";
export default {
    name: "PersonalArea",
    components: {InputImage, BigSize},
    mixins: [inputErrorsMixin, logMixin, fileMixin],
    data() {
        return {
            email: null,
            login: null,
            role: null,
            banned: null,
            oldLogin: null,

            avatar: null,
            image: null,

            feedback: null,

            update: true,
        }
    },
    methods: {
        getMe(){
            myAxios.get(`${API_ROUTES.protected.me}`)
                .then(data => {
                    this.dataLog(data)
                    this.email = data.data.user.email
                    this.login = data.data.user.login
                    this.role = data.data.user.role
                    this.avatar = this.path + data.data.user.avatar
                    this.banned = data.data.user.banned
                })
                .catch(errors => {
                    this.errorsLog(errors)
                })
        },
        save() {
            this.clearErrors()
            const formData = new FormData()
            formData.append('login', this.login)
            if (this.fileImage) {
                this.process = true
                formData.append('avatar', this.fileImage)
            }
            myAxios.post(`${API_ROUTES.protected.updateMe}`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
                onUploadProgress: progressEvent => {
                    this.percent = Math.round((progressEvent.loaded * 100) / progressEvent.total)
                }
            })
                .then(data => {
                    this.dataLog(data)
                    this.email = data.data.user.email
                    this.login = data.data.user.login
                    this.avatar = this.path + data.data.user.avatar
                    this.fileImage = null
                    this.image = null
                    this.update = true
                    this.process = false
                    this.percent = 0
                })
                .catch(errors => {
                    this.errorsLog(errors)
                    if (errors.response.status === 422) this.saveError(errors)
                    this.process = false
                    this.percent = 0
                })
        },
        sendFeedback() {
            this.errors.feedbackError = null
            myAxios.post(`${API_ROUTES.protected.feedbackMe}`, {feedback: this.feedback})
                .then(data => {
                    this.dataLog(data)
                    this.feedback = null
                })
                .catch(errors => {
                    this.errorsLog(errors)
                    if (errors.response.status === 422) this.saveError(errors)
                })
        },
        btnUpdate() {
            this.oldLogin = this.login
            this.update = false
        },
        cancel() {
            this.login = this.oldLogin
            this.fileImage = null
            this.image = null
            this.clearErrors()
            this.update = true
        },
    },
    mounted() {
        this.getMe()
    }
}
</script>

<style scoped>

</style>
