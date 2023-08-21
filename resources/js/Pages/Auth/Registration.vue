<template>
    <div class="container w-2/3 my-auto mx-auto min-h-screen bg-gray-400 bg-opacity-30 pt-10 rounded">
        <div class="grid w-1/3 mx-auto">
            <input v-model="login" class=" my-2.5 h-11 px-2  focus:outline-none focus:border-none" placeholder="Login">
            <p v-if="loginError" class="text-center text-red-400">{{ loginError[0] }}</p>

            <input v-model="email" type="email" class=" my-2.5 h-11 px-2  focus:outline-none focus:border-none"
                   placeholder="Email">
            <p v-if="emailError" class="text-center text-red-400">{{ emailError[0] }}</p>

            <input v-model="password" type="password" class="my-2.5 h-11 px-2  focus:outline-none focus:border-none"
                   placeholder="Password">
            <p v-if="passwordError" class="text-center text-red-400">{{ passwordError[0] }}</p>

            <input v-model="currentPassword" type="password"
                   class="my-2.5 h-11 px-2  focus:outline-none focus:border-none" placeholder="Password Confirmation">
            <p v-if="currentPasswordError" class="text-center text-red-400">{{ currentPasswordError[0] }}</p>

            <div class="min-h-max bg-myCoral">
            </div>
            <input v-on:change="imageChange" type="file" accept="image/*,.png,.jpg,.jpeg,.gif">
            <p v-if="avatarError" class="text-center text-red-400">{{ avatarError[0] }}</p>

            <button @click.prevent="registration" class="my-2.5 h-11 px-2 bg-myCoral text-myWhite">Зарегистрироваться</button>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import {ref} from "vue";
import router from "@/router.js";

export default {
    name: "Registration",
    setup() {
        const login = ref('')
        const email = ref('')
        const password = ref('')
        const currentPassword = ref('')
        const avatar = ref('')
        const loginError = ref('')
        const emailError = ref('')
        const passwordError = ref('')
        const currentPasswordError = ref('')
        const avatarError = ref('')

        const registration = () => {
            axios.get('/sanctum/csrf-cookie', {
                headers: {
                    'Accept': 'application/json',
                    'Content-type': 'application/json'
                }
            })
            .then(data => {
                const csrfToken = document.cookie
                    .split('; ')
                    .find(row => row.startsWith('XSRF-TOKEN'))
                    .split('=')[1];
                axios.post('api/registration', {login: login.value, email: email.value, password: password.value, password_confirmation: currentPassword.value}, {
                    headers: {
                        'Accept': 'application/json',
                        'Content-type': 'application/json',
                        'X-XSRF-TOKEN': csrfToken
                    }
                })
                .then(data => {
                    console.log(data)
                    router.push({name: 'home'})
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
        const imageChange = (event) => {
            avatar.value = event.target.files[0]
        }
        const saveError = (errors) => {
            const arrayErrors = errors.response.data.errors
            loginError.value = arrayErrors.login ?? ''
            emailError.value = arrayErrors.email ?? ''
            passwordError.value = arrayErrors.password ?? ''
            currentPasswordError.value = arrayErrors.password_confirmation ?? ''
            avatarError.value = arrayErrors.avatar ?? ''
        }

        return {
            login,
            email,
            password,
            currentPassword,
            avatar,
            loginError,
            emailError,
            passwordError,
            currentPasswordError,
            avatarError,
            registration,
            imageChange
        }
    }
}
</script>

<style scoped>

</style>
