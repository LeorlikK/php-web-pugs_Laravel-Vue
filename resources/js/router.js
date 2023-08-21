import { createRouter, createWebHistory } from 'vue-router'
import {API_ROUTES} from "@/routs"

const router = createRouter({
    history: createWebHistory(),
    routes:[
        {
            path:'/',
            name:'home',
            component: () => import('./Pages/Main/Main.vue')
        },
        {
            path:'/login',
            name:'login',
            component: () => import('./Pages/Auth/Login.vue')
        },
        {
            path:'/registration',
            name:'registration',
            component: () => import('./Pages/Auth/Registration.vue'),
        },
    ]
})

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('XSRF-TOKEN')

    if (!token) {
        if (to.name in API_ROUTES.public) {
            return next()
        }
    }

    if (token && (to.name === 'login' || to.name === 'registration')) {
        return next({
            name: 'home'
        })
    } else {
        return next()
    }
})

export default router
