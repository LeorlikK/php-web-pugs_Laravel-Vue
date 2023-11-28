<template>
    <div class="container-admin">
        <AdminMenu></AdminMenu>
        <div class="content content-admin-users">
            <div class="admin-edit-news">
                <div class="item item-image">
                    <div class="text text-user">
                        <p class="static">Image:</p>
                        <div class="block-img img-active">
                            <img @click.prevent="changeShowImage(this.image ?? this.avatar)" :src="this.image ?? this.avatar" alt="#" class="photo-img">
                        </div>
                    </div>
                    <div class="text-user">
                        <p v-if="this.errors.imageError" class="error-message text-left">{{ this.errors.imageError[0] }}</p>
                    </div>
                </div>
                <div class="item">
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
                        <p class="static">Title:</p>
                        <input
                            v-model="title"
                            class="value size-12 input-active">
                    </div>
                    <div class="text-user">
                        <p v-if="this.errors.titleError" class="error-message text-left" style="margin-top: 5px">{{ this.errors.titleError[0] }}</p>
                    </div>
                </div>
                <div class="item-flex">
                    <div class="text size-12">
                        <p class="static">Short</p>
                    </div>
                    <div>
                        <textarea v-model="short" class="textarea-users news-textarea"></textarea>
                    </div>
                    <p v-if="this.errors.shortError" class="error-message text-left">{{ this.errors.shortError[0] }}</p>
                </div>
                <div class="item-flex">
                    <div class="text size-12">
                        <p class="static">Text</p>
                    </div>
                    <div>
                        <textarea v-model="text" class="textarea-users news-textarea"></textarea>
                    </div>
                    <p v-if="this.errors.textError" class="error-message text-left">{{ this.errors.textError[0] }}</p>
                </div>
                <div class="item">
                    <div class="text text-user">
                        <p class="static">Publish:</p>
                        <input v-model="publish"
                               :class="publish ? '' : 'checkbox-active'" class="checkbox"
                               type="checkbox">
                    </div>
                </div>

                <div class="update">
                    <a
                        @click.prevent="save"
                        class="btn btn-update btn-active btn-white-c">Сохранить
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
    name: "Create",
    components: {InputImage, AdminMenu, BigSize, MediaMenu},
    mixins: [inputErrorsMixin, logMixin, fileMixin],
    data() {
        return {
            photo_id: router.currentRoute.value.params.photo,
            image: null,
            title: '',
            short: '',
            text: '',
            publish: false,
            avatar: null,
        }
    },
    methods: {
        save() {
            this.clearErrors()
            const formData = new FormData()
            formData.append('title', this.title)
            formData.append('short', this.short)
            formData.append('text', this.text)
            formData.append('publish', this.publish)
            if (this.fileImage) {
                formData.append('image', this.fileImage)
            }
            myAxios.post(`${API_ROUTES.protected.admin_news_store}`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            })
                .then(data => {
                    this.dataLog(data)
                    router.push({name: 'admin_news'})
                })
                .catch(errors => {
                    this.errorsLog(errors)
                    if (errors.response.status === 422) this.saveError(errors)
                })
        },
    },
}
</script>

<style scoped>

</style>
