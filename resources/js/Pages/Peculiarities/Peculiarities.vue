<template>
    <div class="container-peculiarities">
        <h3 class="content-title">{{title}}</h3>
        <div class="content content-peculiarities">
            <p v-html="text"></p>
        </div>
        <div class="category-menu peculiarities-menu">
            <ul>
                <li @click="getPeculiarities(API_ROUTES.public.care)"><router-link :to="{name:'peculiarities_care'}">Уход</router-link></li>
                <li @click="getPeculiarities(API_ROUTES.public.nutrition)"><router-link :to="{name:'peculiarities_nutrition'}">Питание</router-link></li>
                <li @click="getPeculiarities(API_ROUTES.public.health)"><router-link :to="{name:'peculiarities_health'}">Здоровье</router-link></li>
                <li @click="getPeculiarities(API_ROUTES.public.paddock)"><router-link :to="{name:'peculiarities_paddock'}">Выгул</router-link></li>
            </ul>
        </div>
    </div>
</template>

<script>
import {onMounted, ref} from "vue";
import {API_ROUTES} from "@/routs"
import router from "@/router";
import logMixin from "@/mixins/logMixin.js";
import myAxios from "@/myAxios";

export default {
    name: "Peculiarities",
    setup(){
        const { errorsLog, dataLog } = logMixin.methods;
        const title = ref(null)
        const text = ref(null)

        onMounted(() => {
            getPeculiarities(null)
        })
        const getPeculiarities = (url) => {
            router.currentRoute.value.fullPath = url
            myAxios.get(url ?? API_ROUTES.public.peculiarities)
                .then(data => {
                    dataLog(data)
                    title.value = data.data.title
                    text.value = data.data.text
                })
                .catch(errors => {
                    errorsLog(errors)
                })
        }

        return {title, text, getPeculiarities, API_ROUTES}
    }
}
</script>

<style scoped>

</style>
