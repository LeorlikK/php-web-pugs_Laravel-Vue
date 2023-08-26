import { createRouter, createWebHistory } from 'vue-router'
import {API_ROUTES} from "@/routs"

const router = createRouter({
    history: createWebHistory(),
    routes:[
        {
            path: API_ROUTES.public.home,
            name:'home',
            component: () => import('./Pages/Main/Main.vue')
        },
        {
            path: API_ROUTES.public.login,
            name:'login',
            component: () => import('./Pages/Auth/Login.vue')
        },
        {
            path: API_ROUTES.public.registration,
            name:'registration',
            component: () => import('./Pages/Auth/Registration.vue'),
        },
        {
            path: API_ROUTES.public.peculiarities,
            name:'peculiarities',
            component: () => import('./Pages/Peculiarities/Peculiarities.vue'),
        },
        {
            path: API_ROUTES.public.care,
            name:'care',
            component: () => import('./Pages/Auth/Registration.vue'),
        },
        {
            path: API_ROUTES.public.nutrition,
            name:'nutrition',
            component: () => import('./Pages/Auth/Registration.vue'),
        },
        {
            path: API_ROUTES.public.health,
            name:'health',
            component: () => import('./Pages/Auth/Registration.vue'),
        },
        {
            path: API_ROUTES.public.paddock,
            name:'paddock',
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
