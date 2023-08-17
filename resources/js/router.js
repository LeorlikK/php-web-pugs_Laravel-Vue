import { createRouter, createWebHistory } from 'vue-router'

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

export default router
