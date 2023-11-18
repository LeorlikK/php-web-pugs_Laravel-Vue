import {createStore} from "vuex";
import {authModule} from "@/store/authModule";

export default createStore({
    state: () => ({
        typeAuth: 'localStorage', // localStorage/cookie/request
    }),
    getters: {
        getTypeAuth: state => state.typeAuth,
    },
    modules: {
        authModule: authModule
    }
})
