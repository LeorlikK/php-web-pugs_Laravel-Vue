import {createStore} from "vuex";
import {authModule} from "@/store/authModule";
import {echoModule} from "@/store/echoModule";

export default createStore({
    state: () => ({
        typeAuth: 'request', // localStorage/cookie/request
    }),
    getters: {
        getTypeAuth: state => state.typeAuth,
    },
    modules: {
        authModule: authModule,
        echoModule: echoModule
    }
})
