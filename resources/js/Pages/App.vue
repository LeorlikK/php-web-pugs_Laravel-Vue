<template>
    <header>
        <Header></Header>
    </header>
    <router-view></router-view>
</template>

<script>
import Header from "@/Components/Header.vue";
import Main from "@/Pages/Main/Main.vue";
export default {
    name: "App",
    components: {Main, Header}
}
</script>

<style scoped>

</style>
