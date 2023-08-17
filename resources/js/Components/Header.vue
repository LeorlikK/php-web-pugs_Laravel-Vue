<template>
    <div class="flex justify-between">
        <router-link class="w-32 h-11 bg-myCoral text-gray-700 text-myHeaderFontSize uppercase text-gray-800 btn-a" :to="{name: 'home'}">Главная</router-link>
        <router-link class="w-32 h-11 bg-myCoral text-gray-700 text-myHeaderFontSize uppercase text-gray-800 btn-a" :to="{name:'login'}">Вход</router-link>
    </div>
</template>

<script>
export default {
    name: "Header"
}
</script>

<style scoped>

</style>
