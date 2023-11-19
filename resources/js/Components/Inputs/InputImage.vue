<template>
    <div class="img-file">
        <input
            @change="changeImage"
            type="file" class="img-file-input fix-width" id="examplePhotos" accept="image/*,.png,.jpg">
        <div
            :class="this.file?.name ? 'btn-active' : 'btn-cancel'"
            class="img-file-label">
            <label  for="examplePhotos">Выберите изображение:</label>
        </div>
        <p style="margin: auto 0" class="img-file-info">{{ this.file?.name ?? 'Файл не выбран'}}</p>
    </div>
</template>

<script>
export default {
    name: "InputImage",
    props: {
        file: {}
    },
    methods: {
        changeImage(event) {
            this.$emit('changeImage', event)
        }
    }
}
</script>

<style scoped>
.fix-width {
    width: 200px;
}
</style>
