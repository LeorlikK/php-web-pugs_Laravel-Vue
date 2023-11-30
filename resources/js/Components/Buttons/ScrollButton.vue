<template>
    <img src="@src/img/000icon-scrollup000.png" alt="#"
         @click.prevent="topScroll" class="top-scroll">
</template>

<script>
export default {
    name: "ScrollButton",
    methods: {
        topScroll() {
            document.documentElement.scrollTop = 0
        }
    }
}
</script>

<style scoped>

</style>
