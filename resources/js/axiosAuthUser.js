import axios from "axios";
import router from "@/router";
import authMixin from "@/mixins/authMixin";

const axiosAuthUser = axios.create()

axiosAuthUser.interceptors.response.use(response => {
    return response
}, reject => {
    if (reject.response.status === 401 || reject.response.status === 419){
        authMixin.methods.exit()
        router.push({name: 'login'})
    }else {
        return Promise.reject(reject)
    }
})

export default axiosAuthUser
