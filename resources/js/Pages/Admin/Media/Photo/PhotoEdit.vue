<template>
    <div class="container-admin">
        <AdminMenu></AdminMenu>
        <MediaMenu
            photo_route="admin_photo"
            video_route="admin_video"
            audio_route="admin_audio"
        ></MediaMenu>
        <div class="content content-admin-users">
            <div class="admin-edit">

                <div class="item item-image">
                    <div class="text text-user">
                        <p class="static">Avatar:</p>
                        <div class="block-img" :class="update ? '' : 'img-active'">
                            <img @click.prevent="changeShowImage(this.image ?? this.avatar)" :src="this.image ?? this.avatar" alt="#" class="photo-img">
                        </div>
                    </div>
                    <div class="text-user">
                        <p v-if="this.errors.avatarError" class="error-message text-left">{{ this.errors.avatarError[0] }}</p>
                    </div>
                </div>
                <div v-if="!update" class="item">
                    <div class="text text-user">
                        <p class="static"></p>
                        <InputImage
                            :process="process"
                            :percent="percent"
                            :file="this.fileImage"
                            @changeImage="changeImage"
                        ></InputImage>
                    </div>
                </div>

                <div class="item">
                    <div class="text text-user size-12">
                        <p class="static">ID:</p>
                        <input
                            disabled
                            :value="id"
                            class="value input-unactive size-12">
                    </div>
                </div>
                <div class="item">
                    <div class="text text-user size-12">
                        <p class="static">URL:</p>
                        <input
                            disabled
                            :value="url"
                            class="value input-unactive size-12">
                    </div>
                </div>
                <div class="item">
                    <div class="text text-user size-12">
                        <p class="static">Name:</p>
                        <input
                            v-model="name"
                            :disabled="update"
                            :class="update ? 'input-unactive' : 'input-active'" class="value size-12">
                    </div>
                </div>
                <div class="item">
                    <div class="text text-user size-12">
                        <p class="static">Size:</p>
                        <input
                            disabled
                            :value="size"
                            class="value input-unactive size-12">
                    </div>
                </div>
                <div class="item">
                    <div class="text text-user size-12">
                        <p class="static">Created At:</p>
                        <input
                            disabled
                            :value="created_at"
                            class="value input-unactive size-12">
                    </div>
                </div>
                <div class="item">
                    <div class="text text-user size-12">
                        <p class="static">Updated At:</p>
                        <input
                            disabled
                            :value="updated_at"
                            class="value input-unactive size-12">
                    </div>
                </div>
                <div class="update">
                    <a
                        v-if="!update"
                        @click.prevent="save"
                        class="btn btn-update btn-active btn-white-c">Сохранить
                    </a>
                    <a
                        v-if="update"
                        @click.prevent="btnUpdate"
                        class="btn btn-update btn-white-c">Изменить
                    </a>
                    <a
                        v-if="!update"
                        @click.prevent="cancel"
                        class="btn btn-update btn-cancel btn-white-c">Отмена
                    </a>
                </div>
            </div>
        </div>
        <BigSize
            @changeShowImage="changeShowImage"
            :showImage="showImage"
        ></BigSize>
    </div>
</template>

<script>
import AdminMenu from "@/Components/Menu/AdminMenu.vue";
import InputImage from "@/Components/Inputs/InputImage.vue";
import BigSize from "@/Media/BigSize.vue";
import inputErrorsMixin from "@/mixins/inputErrorsMixin";
import logMixin from "@/mixins/logMixin";
import fileMixin from "@/mixins/fileMixin";
import router from "@/router";
import myAxios from "@/myAxios";
import {API_ROUTES} from "@/routs";
import MediaMenu from "@/Components/Menu/MediaMenu.vue";

export default {
    name: "PhotoEdit",
    components: {InputImage, AdminMenu, BigSize, MediaMenu},
    mixins: [inputErrorsMixin, logMixin, fileMixin],
    data() {
        return {
            photo_id: router.currentRoute.value.params.photo,
            image: null,
            update: true,

            id: null,
            url: null,
            name: null,
            size: null,
            created_at: null,
            updated_at: null,
            avatar: null,

            oldName: '',
        }
    },
    methods: {
        getPhoto() {
            myAxios.get(`${API_ROUTES.protected.admin_photo_edit}/${this.photo_id}`)
                .then(data => {
                    this.dataLog(data)
                    data = data.data.data
                    this.id = data.id
                    this.url = data.url
                    this.name = data.name
                    this.size = data.size
                    this.avatar = this.path + data.url
                    this.created_at = data.created_at
                    this.updated_at = data.updated_at
                })
                .catch(errors => {
                    this.errorsLog(errors)
                })
        },
        save() {
            this.clearErrors()
            const formData = new FormData()
            formData.append('name', this.name)
            if (this.fileImage) {
                formData.append('image', this.fileImage)
            }
            myAxios.post(`${API_ROUTES.protected.admin_photo_update}/${this.id}`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            })
                .then(data => {
                    this.dataLog(data)
                    data = data.data.data
                    this.id = data.id
                    this.url = data.url
                    this.name = data.name
                    this.size = data.size
                    this.avatar = this.path + data.url
                    this.created_at = data.created_at
                    this.updated_at = data.updated_at
                    this.fileImage = null
                    this.image = null
                    this.update = true
                })
                .catch(errors => {
                    this.errorsLog(errors)
                    if (errors.response.status === 422) this.saveError(errors)
                })
        },
        btnUpdate() {
            this.oldName = this.name
            this.update = false
        },
        cancel() {
            this.clearErrors()
            this.name = this.oldName
            this.fileImage = null
            this.image = null
            this.update = true
        },
    },
    mounted() {
        this.getPhoto()
    }
}
</script>

<style scoped>

</style>
