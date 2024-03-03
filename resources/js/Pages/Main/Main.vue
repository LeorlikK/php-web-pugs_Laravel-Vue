<template>
    <Disclaimer class="disclaimer"></Disclaimer>
</template>

<script>
import Disclaimer from "@/Components/Disclaimer.vue";
import Menu from "@/Components/Menu/MainMenu.vue";
import myAxios from "@/myAxios";
export default {
    name: "Main",
    components: {Menu, Disclaimer},
    methods: {
        // gett() {
        //     const eventSource = new EventSource('/api/test');
        //
        //     eventSource.onmessage = (event) => {
        //         // Обработка данных, полученных от сервера
        //         console.log(event.data);
        //     };
        //
        //     eventSource.onerror = (error) => {
        //         // Обработка ошибок соединения
        //         console.error('EventSource failed:', error);
        //         eventSource.close();
        //     };
        // }
        gett() {
            fetch('/api/test').then(response => {
            const reader = response.body.getReader()
            const decoder = new TextDecoder()

            const read = () => {
                reader.read().then(({done, value}) => {
                    if(done) return

                    console.log(decoder.decode(value))

                    read()
                })
            }

            read()
        })
        }
    },
    mounted() {
        this.gett()
    }
}
</script>

<style scoped>

</style>
