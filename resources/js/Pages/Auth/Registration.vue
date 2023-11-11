<template>
    <div class="container-registration">
        <div class="content content-registration">
            <div class="registration">
                <div>
                    <input v-model="login" placeholder="Login">
                    <p v-if="this.errors.loginError">{{ this.errors.loginError[0] }}</p>
                </div>
                <div>
                    <input v-model="email" type="email" placeholder="Email">
                    <p v-if="this.errors.emailError">{{ this.errors.emailError[0] }}</p>
                </div>
                <div>
                    <input v-model="password" type="password" placeholder="Password">
                    <p v-if="this.errors.passwordError">{{ this.errors.passwordError[0] }}</p>
                </div>
                <div>
                    <input v-model="currentPassword" type="password" placeholder="Password Confirmation">
                    <p v-if="this.errors.currentPasswordError">{{ this.errors.currentPasswordError[0] }}</p>
                </div>
                <div>
                    <input v-on:change="imageChange" type="file" accept="image/*,.png,.jpg,.jpeg,.gif">
                    <p v-if="this.errors.avatarError">{{ this.errors.avatarError[0] }}</p>
                </div>
                <a @click.prevent="registration" class="btn">Зарегистрироваться</a>
                <router-link :to="{name: 'login'}" class="btn">Назад</router-link>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import {API_ROUTES} from "@/routs"
import inputErrorsMixin from "@/mixins/inputErrorsMixin";
import errorsLogMixin from "@/mixins/errorsLogMixin";
import axiosAuthUser from "@/axiosAuthUser";
import authMixin from "@/mixins/authMixin";

export default {
    name: "Registration",
    mixins: [inputErrorsMixin, errorsLogMixin, authMixin],
    data() {
        return {
            login: '',
            email: '',
            password: '',
            currentPassword: '',
            avatar: '',
            errors: {
                loginError: '',
                emailError: '',
                passwordError: '',
                currentPasswordError: '',
                avatarError: '',
            }
        }
    },
    methods: {
        registration() {
            axios.get('/sanctum/csrf-cookie', {
                headers: {
                    'Accept': 'application/json',
                    'Content-type': 'application/json'
                }
            })
                .then(data => {
                    const csrfToken = this.getCookie('XSRF-TOKEN')
                    axiosAuthUser.post(API_ROUTES.public.registration, {
                        login: this.login,
                        email: this.email,
                        password: this.password,
                        password_confirmation: this.currentPassword
                    }, {
                        headers: {
                            'Accept': 'application/json',
                            'Content-type': 'application/json',
                            'X-XSRF-TOKEN': csrfToken
                        }
                    })
                        .then(data => {
                            this.auth(data)
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
        imageChange(event) {
            this.avatar = event.target.files[0]
        }
    }
}
</script>

<style scoped>

</style>
