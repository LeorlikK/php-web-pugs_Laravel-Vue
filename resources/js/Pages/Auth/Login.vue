<template>
    <div class="container w-2/3 my-auto mx-auto min-h-screen bg-gray-400 bg-opacity-30 pt-10 rounded">
        <div class="grid w-1/3 mx-auto">
            <input v-model="email" class=" my-2.5 h-11 px-2  focus:outline-none focus:border-none" placeholder="Email">
            <p v-if="emailError" class="text-center text-red-400">{{emailError[0]}}</p>
            <input v-model="password" class="my-2.5 h-11 px-2  focus:outline-none focus:border-none" placeholder="Password">
            <p v-if="passwordError" class="text-center text-red-400">{{passwordError[0]}}</p>
            <button @click.prevent="login" class="my-2.5 h-11 px-2 bg-myCoral text-myWhite">Войти</button>
<!--            <button @click.prevent="logout" class="my-2.5 h-11 px-2 bg-myCoral text-myWhite">logout</button>-->
            <router-link :to="{name: 'registration'}" class="my-1 h-12 bg-myCoral btn-a">Зарегистрироваться</router-link>
<!--            <button @click.prevent="personalArea" class="my-2.5 h-11 px-2 bg-myCoral text-myWhite">personalArea</button>-->
<!--            <button @click.prevent="testToken" class="my-2.5 h-11 px-2 bg-myCoral text-myWhite">test-token</button>-->
<!--            <button @click.prevent="me" class="my-2.5 h-11 px-2 bg-myCoral text-myWhite">me</button>-->
<!--            <button @click.prevent="getCookieSanctum" class="my-2.5 h-11 px-2 bg-myCoral text-myWhite">getCookieSanctum</button>-->
        </div>
    </div>
</template>

<script>
export default {
    name: "Login",
    setup(){
        const email = null
        const password = null
        const emailError = null
        const passwordError = null
        const user = null

        const login = () => {
            console.log('LALA')
        }
        const logout = () => {
            console.log('LALA')
        }
        const personalArea = () => {
            console.log('LALA')
        }
        const me = () => {
            console.log('LALA')
        }
        const getCookieSanctum = () => {
            console.log('LALA')
        }
        const testToken = () => {
            console.log('LALA')
        }
        const token = () => {
            console.log('LALA')
        }
        const saveError = () => {
            console.log('LALA')
        }

        return {email, password, emailError, passwordError, user, login}
    }
}
</script>

<style scoped>

</style>
