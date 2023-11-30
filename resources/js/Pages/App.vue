<template>
        <header>
            <Header></Header>
        </header>
        <nav>
            <Menu></Menu>
        </nav>
        <div class="container">
            <router-view></router-view>
        </div>
        <ScrollButton></ScrollButton>
</template>

<script>
import Header from "@/Components/Header.vue";
import Main from "@/Pages/Main/Main.vue";
import ScrollButton from "@/Components/Buttons/ScrollButton.vue";
export default {
    name: "App",
    components: {ScrollButton, Main, Header},
}
</script>

<style scoped>

</style>
