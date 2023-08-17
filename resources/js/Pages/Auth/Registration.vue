<template>
    <div class="container w-2/3 my-auto mx-auto min-h-screen bg-gray-400 bg-opacity-30 pt-10 rounded">
        <div class="grid w-1/3 mx-auto">
            <input v-model="login" class=" my-2.5 h-11 px-2  focus:outline-none focus:border-none" placeholder="Login">
            <p v-if="loginError" class="text-center text-red-400">{{loginError[0]}}</p>

            <input v-model="email" type="email" class=" my-2.5 h-11 px-2  focus:outline-none focus:border-none" placeholder="Email">
            <p v-if="emailError" class="text-center text-red-400">{{emailError[0]}}</p>

            <input v-model="password" type="password" class="my-2.5 h-11 px-2  focus:outline-none focus:border-none" placeholder="Password">
            <p v-if="passwordError" class="text-center text-red-400">{{passwordError[0]}}</p>

            <input v-model="currentPassword" type="password" class="my-2.5 h-11 px-2  focus:outline-none focus:border-none" placeholder="Password Confirmation">
            <p v-if="currentPasswordError" class="text-center text-red-400">{{currentPasswordError[0]}}</p>

            <div class="min-h-max bg-myCoral">
            </div>
            <input v-on:change="imageChange" type="file" accept="image/*,.png,.jpg,.jpeg,.gif">
            <p v-if="avatarError" class="text-center text-red-400">{{avatarError[0]}}</p>

            <button @click.prevent="registration" class="my-2.5 h-11 px-2 bg-myCoral text-myWhite">Зарегистрироваться</button>
            <button @click.prevent="csrfTest" class="my-2.5 h-11 px-2 bg-myCoral text-myWhite">test-csrf</button>
        </div>
    </div>
</template>

<script>
export default {
    name: "Registration",
    setup(){
        const login = ''
        const email = ''
        const password = ''
        const currentPassword = ''
        const avatar = ''
        const loginError = ''
        const emailError = ''
        const passwordError = ''
        const currentPasswordError = ''
        const avatarError = ''

        return {login, email, password, currentPassword, avatar, loginError, emailError, passwordError, currentPasswordError, avatarError}
    }
}
</script>

<style scoped>

</style>
