<template>
    <div class="flex justify-between">
        <router-link class="w-32 h-11 bg-myCoral text-gray-700 text-myHeaderFontSize uppercase text-gray-800 btn-a" :to="{name: 'home'}">Главная</router-link>

        <template v-if="auth">
            <a @click.prevent="logout" class="w-32 h-11 bg-myCoral text-gray-700 text-myHeaderFontSize uppercase text-gray-800 btn-a">Выход</a>
        </template>
        <template v-else>
            <router-link class="w-32 h-11 bg-myCoral text-gray-700 text-myHeaderFontSize uppercase text-gray-800 btn-a" :to="{name:'login'}">Вход</router-link>
        </template>
    </div>
</template>

<script>
import {computed, ref} from "vue";
import {forgotLocalStorage, getLocalStorage} from "@/cookiesManager";
import axios from "axios";
import {API_ROUTES} from "@/routs";
import { onMounted, onUpdated } from 'vue';

export default {
    name: "Header",
    setup() {
        const auth = ref(null)
        const checkAuthUser = () => {
            auth.value = getLocalStorage('XSRF-TOKEN')
        }
        onMounted(() => {
            checkAuthUser()
        })
        onUpdated(() => {
            checkAuthUser()
        })
        const logout = () => {
            axios.post(API_ROUTES.protected.logout)
                .then(data => {
                    forgotLocalStorage('XSRF-TOKEN')
                    checkAuthUser()
                })
                .catch(errors => {
                    console.log(errors);
                })
        }
        return {auth, logout}
    }
}
</script>

<style scoped>

</style>
