<template>
    <div class="menu-admin">
        <ul>
            <li>
                <router-link :to="{name: 'peculiarities'}">Peculiarities</router-link>
            </li>
            <li>
                <router-link :to="{name: 'nurseries'}">Nurseries</router-link>
            </li>
            <li>
                <router-link :to="{name: 'news', query: { page: 1 }}">News</router-link>
            </li>
            <li>
                <router-link :to="{name: 'photos'}">Media</router-link>
            </li>
            <li>
                <router-link :to="{name: 'admin'}">Users</router-link>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "AdminMenu"
}
</script>

<style scoped>

</style>
