import axios from "axios";
import router from "@/router";
import store from "@/store";
const myAxios = axios.create()

myAxios.interceptors.request.use(config => {
    config.headers['X-Socket-Id'] = store.getters['echoModule/Echo'].socketId();
    // config.headers['X-Socket-Id'] = window.Echo ? window.Echo.socketId() : null;
    return config;
})
myAxios.interceptors.response.use(response => {
    return response
}, reject => {
    console.log(reject)
    if (reject.response.status === 401 || reject.response.status === 419){
        router.push({name: 'login'})
        return Promise.reject(reject);
    }else if (reject.response.status === 403) {
        router.push({name: 'home'})
        return Promise.reject(reject)
    }

    return Promise.reject(reject)
})

export default myAxios
