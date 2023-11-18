<template>
    <input :value="value" @input="updateValue" :placeholder="placeholder" :type="type">
</template>

<script>
export default {
    name: "Input",
    props: {
        value: {},
        type: {
            default: ''
        },
        placeholder: {}
    },
    methods: {
        updateValue(event) {
            this.$emit('update', event.target.value);
        },
    },
}
</script>

<style scoped>

</style>
