import router from "@/router";

export default {
    methods: {
        auth(data) {
            const token = this.getCookie('XSRF-TOKEN')
            if (token) {
                this.input(token, data.data.login)
                router.push({name: 'home'})
            }else {
                this.exit()
            }
        },
        check() {
            const token = this.getLocalStorage('XSRF-TOKEN')
            const login = this.getLocalStorage('login')
            if (token) this.$store.commit('changeIsAuth', true)
            if (login) this.$store.commit('changeLogin', login)

        },
        input(token, login) {
            this.setLocalStorage('XSRF-TOKEN', token)
            this.setLocalStorage('login', login)
            this.$store.commit('changeIsAuth', true)
            this.$store.commit('changeLogin', login)
        },
        exit() {
            const token = this.getLocalStorage('XSRF-TOKEN')
            const login = this.getLocalStorage('login')
            if (token) {
                this.forgotLocalStorage('XSRF-TOKEN')
                this.$store.commit('changeIsAuth', false)
            }
            if(login){
                this.forgotLocalStorage('login')
                this.$store.commit('changeLogin', '')
            }
        },
        getCookie(name) {
            let matches = document.cookie.match(new RegExp(
                "(?:^|; )" + name.replace(/([.$?*|{}()[\]\\/+^])/g, '\\$1') + "=([^;]*)"
            ));
            return matches ? decodeURIComponent(matches[1]) : undefined;
        },
        getLocalStorage(name) {
            let value = localStorage.getItem(name)

            return value ? value : undefined
        },
        setLocalStorage(name, value) {
            localStorage.setItem(name, value)
        },
        forgotLocalStorage(name) {
            localStorage.removeItem(name)
        },
    }
}
