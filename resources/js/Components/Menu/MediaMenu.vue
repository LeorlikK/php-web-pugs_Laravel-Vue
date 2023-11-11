<template>
    <div class="category-menu media-menu">
        <ul>
            <li><router-link :to="{name:'photos'}">Photos</router-link></li>
            <li><router-link :to="{name:'video'}">Video</router-link></li>
            <li><router-link :to="{name:'audio'}">Audio</router-link></li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "MediaMenu"
}
</script>

<style scoped>

</style>
