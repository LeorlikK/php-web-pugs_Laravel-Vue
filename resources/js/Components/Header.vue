<template>
    <div>
        <router-link class="btn btn-main" :to="{name: 'home'}">Главная</router-link>
    </div>
    <div>
        <template v-if="this.$store.getters.getIsAuth">
            <a @click.prevent="logout" class="btn btn-main">{{this.$store.getters.getLogin}}</a>
            <div class="user-menu">
                <ul>
                    <li><router-link :to="{name: 'home'}">Личный кабинет</router-link></li>
                    <li><a @click.prevent="logout">Выход</a></li>
                </ul>
            </div>
        </template>
        <template v-else>
            <router-link class="btn btn-main" :to="{name:'login'}">Войти</router-link>
        </template>
    </div>
</template>

<script>
import axios from "axios";
import {API_ROUTES} from "@/routs";
import cookiesMixin from "@/mixins/authMixin";
import errorsLogMixin from "@/mixins/errorsLogMixin";
import axiosAuthUser from "@/axiosAuthUser";

export default {
    name: "Header",
    mixins: [cookiesMixin, errorsLogMixin],
    data() {
        return {
        }
    },
    methods: {
        logout() {
            axiosAuthUser.post(API_ROUTES.public.logout)
                .then(data => {
                    console.log(data);
                    this.exit()
                })
                .catch(errors => {
                    this.errorsLog(errors)
                })
        }
    },
}
</script>

<style scoped>

</style>
