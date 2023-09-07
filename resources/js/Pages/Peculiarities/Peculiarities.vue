<template>
    <h3>{{title}}</h3>
    <p>{{text}}</p>
</template>

<script>
import {onMounted, ref} from "vue";
import axios from "axios";
import {API_ROUTES} from "@/routs"

export default {
    name: "Peculiarities",
    setup(){
        const title = ref(null)
        const text = ref(null)

        onMounted(() => {
            getPeculiarities()
        })
        const getPeculiarities = () => {
            axios.get(API_ROUTES.public.peculiarities)
                .then(data => {
                    console.log(data.data);
                    title.value = data.data.title
                    text.value = data.data.text
                })
                .catch(errors => {
                    console.log(errors);
                })
        }

        return {title, text}
    }
}
</script>

<style scoped>

</style>
