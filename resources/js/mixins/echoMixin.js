export default {
    methods: {
        connectEcho(echo, str1, str2, method) {
            if (echo) {
                echo.channel(str1).listen(str2, response => {
                    method(response)
                })
                if (echo.connector.pusher.connection.state === "disconnected") {
                    echo.connector.pusher.connection.connect();
                }
            }
        },
        disconnectEcho() {
            const echoInstance = this.$store.getters['echoModule/Echo'];
            if (echoInstance) {
                echoInstance.disconnect();
            }
        }
    }
}
