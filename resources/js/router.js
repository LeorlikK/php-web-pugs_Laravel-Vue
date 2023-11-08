import { createRouter, createWebHistory } from 'vue-router'
import {API_ROUTES} from "@/routs"

const router = createRouter({
    history: createWebHistory(), // process.env.BASE_URL
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
            path: '/registration',
            name:'registration',
            component: () => import('./Pages/Auth/Registration.vue'),
        },
        {
            path: '/account/personal-area',
            name:'personal_area',
            component: () => import('./Pages/PersonalArea/PersonalArea.vue'),
        },
        {
            path: '/peculiarities',
            name:'peculiarities',
            component: () => import('./Pages/Peculiarities/Peculiarities.vue'),
            // children: [
            //     {
            //         path: 'care',
            //         name:'care',
            //         component: () => import('./Pages/Peculiarities/Peculiarities.vue'),
            //     },
            //     {
            //         path: '/peculiarities/nutrition',
            //         name:'nutrition',
            //         component: () => import('./Pages/Peculiarities/Peculiarities.vue'),
            //     },
            //     {
            //         path: '/peculiarities/health',
            //         name:'health',
            //         component: () => import('./Pages/Peculiarities/Peculiarities.vue'),
            //     },
            //     {
            //         path: '/peculiarities/paddock',
            //         name:'paddock',
            //         component: () => import('./Pages/Peculiarities/Peculiarities.vue'),
            //     },
            // ]
        },
        {
            path: '/peculiarities/care',
            name:'peculiarities_care',
            component: () => import('./Pages/Peculiarities/Peculiarities.vue'),
        },
        {
            path: '/peculiarities/nutrition',
            name:'peculiarities_nutrition',
            component: () => import('./Pages/Peculiarities/Peculiarities.vue'),
        },
        {
            path: '/peculiarities/health',
            name:'peculiarities_health',
            component: () => import('./Pages/Peculiarities/Peculiarities.vue'),
        },
        {
            path: '/peculiarities/paddock',
            name:'peculiarities_paddock',
            component: () => import('./Pages/Peculiarities/Peculiarities.vue'),
        },
        {
            path: '/nurseries',
            name:'nurseries',
            component: () => import('./Pages/Nurseries/Nurseries.vue'),
        },
        {
            path: '/news',
            name:'news',
            component: () => import('./Pages/News/Index.vue'),
        },
        {
            path: '/news/show',
            name:'news_show',
            component: () => import('./Pages/News/Show.vue'),
        },
        {
            path: '/photos',
            name:'photos',
            component: () => import('./Pages/Media/Photo.vue'),
        },
        {
            path: '/video',
            name:'video',
            component: () => import('./Pages/Media/Video.vue'),
        },
        {
            path: '/audio',
            name:'audio',
            component: () => import('./Pages/Media/Audio.vue'),
        },
        {
            path: '/admin',
            name:'admin',
            component: () => import('./Pages/Admin/Index.vue'),
        }
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
