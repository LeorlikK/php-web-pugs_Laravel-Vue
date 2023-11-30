import myAxios from "@/myAxios";
import {API_ROUTES} from "@/routs";
import indexStore  from '@/store/index.js'
import cookieService from '@/services/cookieService.js'
import localStorageService from '@/services/localStorageService.js'

export function authService() {
    const checkAuth = async () => {
        let token, user;
        const typeAuth = indexStore.getters['getTypeAuth']
        if (typeAuth === 'localStorage') {
            token = localStorageService.getLocalStorage('XSRF-TOKEN')
            user = localStorageService.getLocalStorage('user')
        } else if(typeAuth === 'cookie') {
            token = cookieService.getCookie('token') ? JSON.parse(cookieService.getCookie('token')) : undefined
            user = cookieService.getCookie('user') ? JSON.parse(cookieService.getCookie('user')) : undefined
        } else if (typeAuth === 'request'){
            const result = await getRequest()
            if (result && result?.data?.user) {
                user = result.data.user
                token = 'testToken'
            }
        }

        indexStore.commit('authModule/changeToken', token ?? null)
        indexStore.commit('authModule/changeUser', user ?? null)
    }
    const getMe = async () => {
        return await myAxios.get(`${API_ROUTES.protected.me}`)
            .then(data => {
                indexStore.commit('authModule/changeUser', data.data.user)
                return data
            })
            .catch(error => {
                return error
            });
    }
    const auth = (data, type) => {
        if (type === 'enter') {
            const token = cookieService.getCookie('XSRF-TOKEN')
            if (token) {
                enter(token, data.data.user)
            }else {
                exit()
            }
        } else if (type === 'exit') {
            exit()
        }
    }
    function enter(token, user) {
        const typeAuth = indexStore.getters['getTypeAuth']
        if (typeAuth === 'localStorage') {
            localStorageService.setLocalStorage('XSRF-TOKEN', token)
            localStorageService.setLocalStorage('user', user)
        } else if(typeAuth === 'cookie') {
            cookieService.setCookie('user', user, 30)
            cookieService.setCookie('token', token, 30)
        } else {}

        indexStore.commit('authModule/changeUser', user)
        indexStore.commit('authModule/changeToken', token)
    }
    function exit() {
        const typeAuth = indexStore.getters['getTypeAuth']
        if (typeAuth === 'localStorage') {
            localStorageService.forgotLocalStorage('XSRF-TOKEN')
            localStorageService.forgotLocalStorage('user')
        } else if(typeAuth === 'cookie') {
            cookieService.forgotCookie('user')
            cookieService.forgotCookie('token')
        } else {
            forgotRequest()
        }

        indexStore.commit('authModule/changeToken', null)
        indexStore.commit('authModule/changeUser', null)
    }
    function setRequest() {}
    async function getRequest() {
        return await getMe()
    }
    function forgotRequest() {
        cookieService.forgotCookie('XSRF-TOKEN')
    }

    return {getMe, checkAuth, auth}
}
