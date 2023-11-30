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
import {API_ROUTES} from "@/routs";
import inputErrorsMixin from "@/mixins/inputErrorsMixin";
import logMixin from "@/mixins/logMixin";
import myAxios from "@/myAxios";
import router from "@/router";
import {authService} from "@/services/authService";

export default {
    name: "Header",
    mixins: [inputErrorsMixin, logMixin],
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
            myAxios.post(API_ROUTES.public.logout)
                .then(data => {
                    authService().auth(data, 'exit')
                    router.push({name: 'home'})
                })
                .catch(errors => {
                    this.errorsLog(errors)
                })
        },
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
