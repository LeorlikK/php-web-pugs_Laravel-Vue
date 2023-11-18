<template>
    <div class="container-login">
        <div class="content content-login">
            <div class="login">
                <div>
                    <Input :value="email" @update="updateEmail" placeholder="Email"></Input>
                    <p v-if="this.errors.emailError">{{ this.errors.emailError[0] }}</p>
                </div>
                <div>
                    <Input :value="password" @update="updatePassword" placeholder="Password" type="password"></Input>
                    <p v-if="this.errors.passwordError">{{ this.errors.passwordError[0] }}</p>
                </div>
                <a @click.prevent="login" class="btn">Войти</a>
                <router-link :to="{name: 'registration'}" class="btn">Регистрация</router-link>
            </div>
        </div>
    </div>

</template>

<script>
import {API_ROUTES} from "@/routs"
import inputErrorsMixin from "@/mixins/inputErrorsMixin";
import logMixin from "@/mixins/logMixin";
import myAxios from "@/myAxios";
import router from "@/router";
import {authService} from "@/services/authService";
import Input from "@/Components/Inputs/Input.vue";
import inputMixin from "@/mixins/inputMixin";

export default {
    name: "Login",
    components: {Input},
    mixins: [inputErrorsMixin, logMixin, inputMixin],
    data() {
        return {
            email: '',
            password: '',
        }
    },
    methods: {
        login() {
            myAxios.get('/sanctum/csrf-cookie')
                .then(data => {
                    this.dataLog(data)
                    myAxios.post(API_ROUTES.public.login, {
                        email: this.email, password: this.password
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
    },
}
</script>

<style scoped>

</style>
