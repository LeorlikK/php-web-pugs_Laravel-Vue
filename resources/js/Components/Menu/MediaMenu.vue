<template>
    <div class="category-menu media-menu">
        <ul>
            <li><router-link :to="{name: photo_route}">Photos</router-link></li>
            <li><router-link :to="{name: video_route}">Video</router-link></li>
            <li><router-link :to="{name: audio_route}">Audio</router-link></li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "MediaMenu",
    props: {
        photo_route: String,
        video_route: String,
        audio_route: String
    }
}
</script>

<style scoped>

</style>
