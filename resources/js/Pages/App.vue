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
</template>

<script>
import Header from "@/Components/Header.vue";
import Main from "@/Pages/Main/Main.vue";
import authMixin from "@/mixins/authMixin";
export default {
    name: "App",
    components: {Main, Header},
    mixins: [authMixin],
    beforeMount() {
        this.check()
    },
}
</script>

<style scoped>

</style>
