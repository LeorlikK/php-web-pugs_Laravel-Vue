<template>
    <div class="menu-main">
        <h3>Меню</h3>
        <ul>
            <li>
                <router-link :to="{name: 'peculiarities'}">Особенности породы</router-link>
            </li>
            <li>
                <router-link :to="{name: 'nurseries'}">Питомники</router-link>
            </li>
            <li>
                <router-link :to="{name: 'news', query: { page: 1 }}">Новости</router-link>
            </li>
            <li>
                <router-link :to="{name: 'photos'}">Медиа</router-link>
            </li>
            <li v-if="this.$store.getters['authModule/getIsAuth'] && this.$store.getters['authModule/getIsAdmin']">
                <router-link :to="{name: 'admin'}">Админка</router-link>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "Menu"
}
</script>

<style scoped>

</style>
