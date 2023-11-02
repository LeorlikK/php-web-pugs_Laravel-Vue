<template>
    <div class="content">
        <div class="login">
            <div>
                <input v-model="email" placeholder="Email">
                <p v-if="this.errors.emailError">{{ this.errors.emailError[0] }}</p>
            </div>
            <div>
                <input v-model="password" type="password" placeholder="Password">
                <p v-if="this.errors.passwordError">{{ this.errors.passwordError[0] }}</p>
            </div>
            <a @click.prevent="login" class="btn">Войти</a>
            <router-link :to="{name: 'registration'}" class="btn">Регистрация</router-link>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import {API_ROUTES} from "@/routs"
import inputErrorsMixin from "@/mixins/inputErrorsMixin";
import errorsLogMixin from "@/mixins/errorsLogMixin";
import cookiesMixin from "@/mixins/authMixin";
import axiosAuthUser from "@/axiosAuthUser";

export default {
    name: "Login",
    mixins: [inputErrorsMixin, errorsLogMixin, cookiesMixin],
    data() {
        return {
            email: '',
            password: '',
            errors: {
                emailError: '',
                passwordError: '',
            }
        }
    },
    methods: {
        login() {
            axiosAuthUser.get('/sanctum/csrf-cookie')
                .then(data => {
                    console.log(data);
                    axiosAuthUser.post(API_ROUTES.public.login, {
                        email: this.email, password: this.password
                    })
                        .then(data => {
                            console.log(data.data);
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
    },
}
</script>

<style scoped>

</style>
