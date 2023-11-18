<template>
    <div v-show="showImage" @click="closeWindow($event)" class="background">
        <div @click="stopPropagation" class="contentWindow">
            <CloseWindow
                @closeButton="closeButton"
            ></CloseWindow>
            <img :src="showImage" alt="#" class="image photo-img">
        </div>
    </div>
</template>

<script>
import CloseWindow from "@/Media/CloseWindow.vue";
export default {
    name: "BigSize",
    components: {CloseWindow},
    emits: ['changeShowImage'],
    props: {
        showImage: {}
    },
    methods: {
        closeButton() {
            this.closeWindow()
        },
        closeWindow(event) {
            this.$emit('changeShowImage', false)
        },
        stopPropagation(event) {
            event.stopPropagation();
        }
    }
}
</script>

<style scoped>
.background {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(128, 128, 128, 0.5);
    z-index: 9000;
    font-weight: bolder;
}
.contentWindow {
    position: absolute;
    padding: 15px;
    top: 50%;
    left: 50%;
    width: 90%;
    height: 90%;
    background-color: rgba(128, 128, 128, 0.5);
    transform: translate(-50%, -50%);
    display: flex;
    border: 2px solid lightcoral;
    border-radius: 10px;
}
</style>
