<template>
    <div class="container-admin">
        <AdminMenu></AdminMenu>
        <div class="content content-admin">
            <div class="statistic">
                <div class="user-stats">
                    <div>
                        <p>All Users:</p>
                        <p>{{all_users}}</p>
                    </div>
                    <div>
                        <p>Users banned:</p>
                        <p>{{users_banned}}</p>
                    </div>
                    <div>
                        <p>Users in the two week ago:</p>
                        <p>{{newUsersTwoWeekAgo}}</p>
                    </div>
                    <div>
                        <p>Users last week:</p>
                        <p>{{newUsersLastWeek}}</p>
                    </div>
                </div>
                <div class="media-stats">
                    <div class="photo-size"><p>Photos Size:</p><p>{{photo_size}} ({{photo_size_percent}}%)</p></div>
                    <div class="video-size"><p>Video Size:</p><p>{{video_size}} ({{video_size_percent}}%)</p></div>
                    <div class="audio-size"><p>Audio Size:</p><p>{{audio_size}} ({{audio_size_percent}}%)</p></div>
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
import myAxios from "../../myAxios";
import {API_ROUTES} from "../../routs";
import logMixin from "../../mixins/logMixin";
export default {
    name: "Index",
    components: {AdminMenu},
    mixins: [logMixin],
    data() {
        return {
            photo_size: null,
            video_size: null,
            audio_size: null,
            photo_size_percent: null,
            video_size_percent: null,
            audio_size_percent: null,
            all_users: null,
            users_banned: null,
            newUsersLastWeek: null,
            newUsersTwoWeekAgo: null,
            usersDifferencePercentWeeks: null,
        }
    },
    methods: {
        getStatistics() {
            myAxios.get(`${API_ROUTES.protected.admin_statistics}`)
                .then(data => {
                    this.dataLog(data)
                    data = data.data
                    this.photo_size = data.media.photoSizeSum
                    this.video_size = data.media.videoSizeSum
                    this.audio_size = data.media.audioSizeSum
                    this.photo_size_percent = data.media.percentagePhoto
                    this.video_size_percent = data.media.percentageVideo
                    this.audio_size_percent = data.media.percentageAudio
                    this.all_users = data.users.usersAllCount
                    this.users_banned = data.users.usersBannedCount
                    this.newUsersLastWeek = data.users.newUsersLastWeek
                    this.newUsersTwoWeekAgo = data.users.newUsersTwoWeekAgo
                    this.usersDifferencePercentWeeks = data.users.usersDifferencePercentWeeks
            })
        },
        getLinearGradient() {
            return `linear-gradient(90deg, #20A7FBE2 0%, #20A7FBE2 ${this.photo_size}%,
            #6527FDDB ${this.photo_size}%, #6527FDDB ${this.video_size}%,
            #FF6363E5 ${this.video_size}%, #FF6363E5 100%)`;
        }
    },
    mounted() {
        this.getStatistics()
    }
}
</script>

<style scoped>
</style>
