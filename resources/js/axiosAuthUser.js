import axios from "axios";
import router from "@/router";

const axiosAuthUser = axios.create()

axiosAuthUser.interceptors.response.use(response => {}, reject => {
    if (reject.status === 401 || reject.status === 419){
        const token = localStorage.getItem('XSRF-TOKEN')
        if (token){
            localStorage.removeItem('XSRF-TOKEN')
        }
        router.push({name: 'login'})
    }
})

export default axiosAuthUser
