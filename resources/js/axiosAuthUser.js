import axios from "axios";
import router from "@/router";
import authMixin from "@/mixins/authMixin";

const axiosAuthUser = axios.create()

axiosAuthUser.interceptors.response.use(response => {
    return response
}, reject => {
    if (reject.response.status === 401 || reject.response.status === 419){
        router.push({name: 'login'})
        router.replace({name: 'login'})
        return Promise.reject(reject);
    }else if (reject.response.status === 403) {
        router.push({name: 'home'})
        router.replace({name: ''})
        return Promise.reject(reject)
    }

    return Promise.reject(reject)
})

export default axiosAuthUser
