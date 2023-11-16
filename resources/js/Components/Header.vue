<template>
    <div>
        <router-link class="btn btn-main" :to="{name: 'home'}">Главная</router-link>
    </div>
    <div>
        <template v-if="this.$store.getters['authModule/getIsAuth']">
            <a @click.prevent="logout" class="btn btn-main">{{this.$store.getters['authModule/getLogin']}}</a>
            <div class="user-menu">
                <ul>
                    <li><router-link :to="{name: 'personal_area'}">Личный кабинет</router-link></li>
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
import axiosAuthUser from "@/axiosAuthUser";
import authMixin from "@/mixins/authMixin";
import logMixin from "@/mixins/logMixin";
// import {mapActions, mapGetters, mapMutations, mapState} from "vuex";

export default {
    name: "Header",
    mixins: [cookiesMixin, logMixin, authMixin],
    data() {
        return {
        }
    },
    methods: {
        // ...mapMutations({
        //     changeIsAuth: 'authModule/changeLogin'
        // }),
        // ...mapActions({
        //
        // }),
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
    // computed: {
    //     ...mapState({
    //         testRole: state => state.authModule.role
    //     }),
    //     ...mapGetters('authModule', {
    //         getIsAuth: 'getIsAuth',
    //         getLogin: 'getLogin',
    //         getAdmin: 'getAdmin',
    //         getVerify: 'getVerify'
    //     })
    // },
    mounted() {
    }
}
</script>

<style scoped>

</style>
