import { createRouter, createWebHistory } from 'vue-router'
import {API_ROUTES} from "@/routs"

const router = createRouter({
    history: createWebHistory(),
    routes:[
        {
            path: '/',
            name:'home',
            component: () => import('./Pages/Main/Main.vue')
        },
        {
            path: '/login',
            name:'login',
            component: () => import('./Pages/Auth/Login.vue')
        },
        {
            path: '/api/account/registration',
            name:'registration',
            component: () => import('./Pages/Auth/Registration.vue'),
        },
        {
            path: '/peculiarities',
            name:'peculiarities',
            component: () => import('./Pages/Peculiarities/Peculiarities.vue'),
            children: [
                {
                    path: '/peculiarities/care',
                    name:'care',
                    component: () => import('./Pages/Auth/Registration.vue'),
                },
                {
                    path: '/peculiarities/nutrition',
                    name:'nutrition',
                    component: () => import('./Pages/Auth/Registration.vue'),
                },
                {
                    path: '/peculiarities/health',
                    name:'health',
                    component: () => import('./Pages/Auth/Registration.vue'),
                },
                {
                    path: '/peculiarities/paddock',
                    name:'paddock',
                    component: () => import('./Pages/Auth/Registration.vue'),
                },
            ]
        },
        {
            path: '/nurseries/:page?',
            name:'nurseries',
            component: () => import('./Pages/Nurseries/Nurseries.vue'),
        },
        {
            path: '/news/:page?',
            name:'news',
            component: () => import('./Pages/News/Index.vue'),
            // children: [
            //     {
            //         path: '/peculiarities/care',
            //         name:'care',
            //         component: () => import('./Pages/Auth/Registration.vue'),
            //     },
            // ]
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
