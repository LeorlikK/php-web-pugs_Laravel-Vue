<template>
    <div  @click.prevent="close" class="close-button-position">
        <div class="close-button"></div>
    </div>
</template>

<script>
export default {
    name: "CloseWindow",
    emits: ['closeButton'],
    methods: {
        close() {
            this.$emit('closeButton')
        }
    }
}
</script>

<style scoped>
.close-button {
    width: 30px;
    height: 30px;
    position: relative;
    cursor: pointer;
}

.close-button::before,
.close-button::after {
    content: "";
    position: absolute;
    top: 50%;
    left: 0;
    width: 100%;
    height: 2px;
    background-color: black;
    transform: translateY(-50%);
}

.close-button::before {
    transform: rotate(45deg);
}

.close-button::after {
    transform: rotate(-45deg);
}
.close-button:hover {
    background-color: lightcoral;
}
</style>
