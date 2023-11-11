<template>
    <div class="container-admin">
        <AdminMenu></AdminMenu>
        <div class="content content-admin">
            <div class="statistic">
                <div class="user-stats">
                    <div>
                        <p>All Users:</p>
                        <p>3</p>
                    </div>
                    <div>
                        <p>Users banned:</p>
                        <p>3</p>
                    </div>
                    <div>
                        <p>Users in the last week:</p>
                        <p>3</p>
                    </div>
                    <div>
                        <p>Users last week:</p>
                        <p>3</p>
                    </div>
                </div>
                <div class="media-stats">
                    <div class="photo-size"><p>Photos Size:</p><p>830971KB (19.86%)</p></div>
                    <div class="video-size"><p>Video Size:</p><p>0KB (0%)</p></div>
                    <div class="audio-size"><p>Audio Size:</p><p>3.2Mb (80.14%)</p></div>
                    <div class="all-size"><p>All Size:</p><p>4Mb</p></div>
                    <div><a>Обновить данные</a></div>
                </div>
                <div
                    :style="{background: getLinearGradient()}"
                    class="stat-line">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import AdminMenu from "@/Components/Menu/AdminMenu.vue";
export default {
    name: "Index",
    components: {AdminMenu},
    data() {
        return {
            photo_size: 10,
            video_size: 70,
            audio_size: 20,
        }
    },
    methods: {
        getLinearGradient() {
            return `linear-gradient(90deg, #20A7FBE2 0%, #20A7FBE2 ${this.photo_size}%,
            #6527FDDB ${this.photo_size}%, #6527FDDB ${this.video_size}%,
            #FF6363E5 ${this.video_size}%, #FF6363E5 100%)`;
        }
    },
}
</script>

<style scoped>
</style>
