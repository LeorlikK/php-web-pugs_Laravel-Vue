<template>
    <header>
        <Header></Header>
    </header>
    <Menu></Menu>
    <router-view></router-view>
</template>

<script>
import Header from "@/Components/Header.vue";
import Main from "@/Pages/Main/Main.vue";
import {ref} from "vue";
export default {
    name: "App",
    components: {Main, Header},
    setup(){
    }
}
</script>

<style scoped>

</style>
