import axios from "axios";
import router from "@/router";

const myAxios = axios.create()

myAxios.interceptors.response.use(response => {
    return response
}, reject => {
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
