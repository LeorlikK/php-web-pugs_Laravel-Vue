<template>
    <div class="container-registration">
        <div class="content content-registration">
            <div class="registration">
                <div>
                    <Input :value="login" @update="updateLogin" placeholder="Login"></Input>
                    <p v-if="this.errors.loginError">{{ this.errors.loginError[0] }}</p>
                </div>
                <div>
                    <Input :value="email" @update="updateEmail" placeholder="Email" type="Email"></Input>
                    <p v-if="this.errors.emailError">{{ this.errors.emailError[0] }}</p>
                </div>
                <div>
                    <Input :value="password" @update="updatePassword" placeholder="Password" type="password"></Input>
                    <p v-if="this.errors.passwordError">{{ this.errors.passwordError[0] }}</p>
                </div>
                <div>
                    <Input :value="currentPassword" @update="updateCurrentPassword" placeholder="Password Confirmation" type="password"></Input>
                    <p v-if="this.errors.currentPasswordError">{{ this.errors.currentPasswordError[0] }}</p>
                </div>
                <div>
                    <InputImage
                        :file="this.file"
                        @changeImage="changeImage"
                    ></InputImage>

                    <p v-if="this.errors.avatarError">{{ this.errors.avatarError[0] }}</p>
                </div>
                <a @click.prevent="registration" class="btn">Зарегистрироваться</a>
                <router-link :to="{name: 'login'}" class="btn">Назад</router-link>
            </div>
        </div>
    </div>
</template>

<script>
import {API_ROUTES} from "@/routs"
import inputErrorsMixin from "@/mixins/inputErrorsMixin";
import logMixin from "@/mixins/logMixin";
import myAxios from "@/myAxios";
import {authService} from "@/services/authService";
import cookieService from '@/services/cookieService.js'
import router from "@/router";
import Input from "@/Components/Inputs/Input.vue";
import inputMixin from "@/mixins/inputMixin";
import InputImage from "@/Components/Inputs/InputImage.vue";
import imageMixin from "@/mixins/imageMixin";

export default {
    name: "Registration",
    components: {InputImage, Input},
    mixins: [inputErrorsMixin, logMixin, inputMixin, imageMixin],
    data() {
        return {
            login: '',
            email: '',
            password: '',
            currentPassword: '',
            avatar: '',
            file: null,
        }
    },
    methods: {
        registration() {
            const formData = new FormData()
            formData.append('login', this.login)
            formData.append('email', this.email)
            formData.append('password', this.password)
            formData.append('password_confirmation', this.currentPassword)
            if (this.file) {
                console.log(this.file)
                formData.append('avatar', this.file)
            }
            myAxios.get('/sanctum/csrf-cookie', {
                headers: {
                    'Accept': 'application/json',
                    'Content-type': 'application/json'
                }
            })
                .then(data => {
                    this.dataLog(data)
                    const csrfToken = cookieService.getCookie('XSRF-TOKEN')
                    myAxios.post(API_ROUTES.public.registration, formData,
            {
                        headers: {
                            'Accept': 'application/json',
                            'Content-type': 'application/json',
                            'Content-Type': 'multipart/form-data',
                            'X-XSRF-TOKEN': csrfToken
                        }
                    })
                        .then(data => {
                            this.dataLog(data)
                            authService().auth(data, 'enter')
                            router.push({name: 'home'})
                        })
                        .catch(errors => {
                            this.errorsLog(errors)
                            if (errors.response.status === 422) this.saveError(errors)
                        })
                })
                .catch(errors => {
                    this.errorsLog(errors)
                })
        },
    }
}
</script>

<style scoped>

</style>
