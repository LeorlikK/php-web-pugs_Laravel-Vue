<template>
    <div @click.prevent="no" :hidden="question === false" class="confirm">
        <div class="confirmWindow">
            <div class="question">
                <p class="text-white-c">{{ text }}</p>
            </div>
            <div class="answer">
                <a @click.prevent.stop="yes" class="yes btn btn-white-c">Да</a>
                <a @click.prevent.stop="no" class="cancel btn btn-white-c">Нет</a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Confirm",
    emits: ['answer'],
    props: {
        text: {
            type: String
        },
        question: {
            type: Boolean
        }
    },
    methods: {
        yes() {
            this.$emit('answer', true)
        },
        no() {
            this.$emit('answer', false)
        },
    }
}
</script>

<style scoped>
.confirm {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(128, 128, 128, 0.5);
    z-index: 9000;
    font-weight: bolder;
}
.confirmWindow {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 400px;
    height: 200px;
    background-color: rgba(128, 128, 128, 0.5);
    transform: translate(-50%, -50%);
    display: grid;
    border: 2px solid lightcoral;
    border-radius: 10px;
}
.question {
    grid-column: 1/3;
    grid-row: 1/2;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 35px 35px 0 35px;
    background-color: lightcoral;
    border-radius: 10px;
}
.question p {
    text-align: center;
}
.answer {
    grid-column: 1/3;
    grid-row: 2/3;
    width: 200px;
    height: 50px;
    justify-content: space-between;
    display: flex;
    margin: auto;
}
.yes {
    width: 50px;
    height: 30px;
    text-align: center;
    vertical-align: bottom;
}
.cancel {
    width: 50px;
    height: 30px;
}
</style>
