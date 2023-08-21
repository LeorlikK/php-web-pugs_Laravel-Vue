<template>
    <div class="container w-2/3 my-auto mx-auto min-h-screen bg-gray-400 bg-opacity-30 pt-10 rounded">
        <div class="grid w-1/3 mx-auto">
            <input v-model="email" class=" my-2.5 h-11 px-2  focus:outline-none focus:border-none" placeholder="Email">
            <p v-if="emailError" class="text-center text-red-400">{{emailError[0]}}</p>
            <input v-model="password" type="password" class="my-2.5 h-11 px-2  focus:outline-none focus:border-none" placeholder="Password">
            <p v-if="passwordError" class="text-center text-red-400">{{passwordError[0]}}</p>
            <button @click.prevent="login" class="my-2.5 h-11 px-2 bg-myCoral text-myWhite">Войти</button>
            <button @click.prevent="protectedRoute" class="my-2.5 h-11 px-2 bg-myCoral text-myWhite">ProtectedRoute</button>
            <router-link :to="{name: 'registration'}" class="my-1 h-12 bg-myCoral btn-a">Регистрация</router-link>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import {ref} from "vue";
import axiosAuthUser from "@/axiosAuthUser";
import {forgotLocalStorage, setLocalStorage, getCookie} from "@/cookiesManager"
import {API_ROUTES} from "@/routs"
import router from "@/router"

export default {
    name: "Login",
    setup(){
        const email = ref('')
        const password = ref('')
        const emailError = ref('')
        const passwordError = ref('')
        const user = ref('')

        const protectedRoute = () => {
            axiosAuthUser.get('/api/protected', {
                headers: {
                    'Accept': 'application/json',
                    'Content-type': 'application/json',
                }
            })
            .then(data => {
                console.log(data)
            })
            .catch(errors => {
                console.log(errors);
            })
        }
        const login = () => {
            axios.get('/sanctum/csrf-cookie', {
                headers: {
                    'Accept': 'application/json',
                    'Content-type': 'application/json'
                }
            })
            .then(data => {
                axios.post(API_ROUTES.public.login, {email: email.value, password: password.value}, {
                    headers: {
                        'Accept': 'application/json',
                        'Content-type': 'application/json',
                    }
                })
                .then(data => {
                    const token = getCookie('XSRF-TOKEN')
                    console.log(token)
                    if (token) {
                        setLocalStorage('XSRF-TOKEN', token)
                        router.push({name: 'home'})
                    }
                })
                .catch(errors => {
                    console.log(errors);
                    if (errors.response.status === 422) saveError(errors)
                })
            })
            .catch(error => {
                console.log(error);
            })
        }
        const saveError = (errors) => {
            const arrayErrors = errors.response.data.errors
            emailError.value = arrayErrors.email ?? ''
            passwordError.value = arrayErrors.password ?? ''
        }

        return {email, password, emailError, passwordError, user, login, protectedRoute}
    }
}
</script>

<style scoped>

</style>
