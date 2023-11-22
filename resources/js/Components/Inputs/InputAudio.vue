<template>
    <div class="img-file">
        <input
            @change="changeAudio"
            type="file" class="img-file-input fix-width" id="examplePhotos" accept="audio/*,.mp3">
        <div
            :class="this.file?.name ? 'btn-active' : 'btn-cancel'"
            class="img-file-label">
            <label  for="examplePhotos">Выберите файл:</label>
        </div>
        <p style="margin: auto 0" class="img-file-info">{{ this.file?.name ?? 'Файл не выбран'}}</p>
    </div>
    <div v-if="process" style="position: relative">
        <div class="process-loading" :style="{background: getLinearGradient()}">
        </div>
        <p class="text-percent">{{percent}}%</p>
    </div>
</template>

<script>
export default {
    name: "InputAudio",
    emits: ['changeAudio'],
    props: {
        file: {},
        percent: {type: Number},
        process: {type: Boolean, default: false}
    },
    data() {
        return {
            loaded: 0
        }
    },
    methods: {
        changeAudio(event) {
            this.$emit('changeAudio', event)
        },
        getLinearGradient() {
            return `linear-gradient(135deg, #73C6B6 0%, #73C6B6 ${this.percent}%,
            #000 ${this.percent}%, #000 ${this.percent+0.2}%,
            #FF6363E5 ${this.percent+0.2}%, #FF6363E5 100%)`;
        }
    }
}
</script>

<style scoped>

</style>
