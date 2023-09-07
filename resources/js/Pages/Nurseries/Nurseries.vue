<template>

</template>

<script>
import axios from "axios";
import {API_ROUTES} from "@/routs";
import {onMounted} from "vue";
import router from "@/router";

export default {
    name: "Nurseries",
    setup(){
        onMounted(() => {
            getNurseries()
        })
        const getNurseries = () => {
            axios.get(`/api/nurseries/${router.currentRoute.value.params.page}`)
                .then(data => {
                    console.log(data)
                })
                .catch(errors => {
                    console.log(errors);
                })
        }
        return {}
    }
}
</script>

<style scoped>

</style>
