import { createRouter, createWebHistory } from 'vue-router'
import admin from "@/router/middleware/admin.js"
import verify_email from "@/router/middleware/verify_email.js"
import redirectIfAuth from "@/router/middleware/redirectIfAuth.js"
import { nextMiddleware } from "@/router/middleware/middlewareForEach.js";

const router = createRouter({
    history: createWebHistory(), // process.env.BASE_URL
    routes:[
        {
            path: '/',
            name:'home',
            component: () => import('./Pages/Main/Main.vue'),
            meta: {
                title: 'HOME'
            }
        },
        {
            path: '/login',
            name:'login',
            component: () => import('./Pages/Auth/Login.vue'),
            meta: {
                middleware: [
                    redirectIfAuth
                ],
                title: 'Login'
            }
        },
        {
            path: '/registration',
            name:'registration',
            component: () => import('./Pages/Auth/Registration.vue'),
            meta: {
                middleware: [
                    redirectIfAuth
                ],
                title: 'Registration'
            }
        },
        {
            path: '/account/personal-area',
            name:'personal_area',
            component: () => import('./Pages/PersonalArea/PersonalArea.vue'),
            meta: {
                title: 'Personal-Area'
            }
        },
        {
            path: '/peculiarities',
            name:'peculiarities',
            component: () => import('./Pages/Peculiarities/Peculiarities.vue'),
            meta: {
                title: 'Peculiarities'
            }
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
            meta: {
                title: 'Peculiarities Care'
            }
        },
        {
            path: '/peculiarities/nutrition',
            name:'peculiarities_nutrition',
            component: () => import('./Pages/Peculiarities/Peculiarities.vue'),
            meta: {
                title: 'Peculiarities Nutrition'
            }
        },
        {
            path: '/peculiarities/health',
            name:'peculiarities_health',
            component: () => import('./Pages/Peculiarities/Peculiarities.vue'),
            meta: {
                title: 'Peculiarities Health'
            }
        },
        {
            path: '/peculiarities/paddock',
            name:'peculiarities_paddock',
            component: () => import('./Pages/Peculiarities/Peculiarities.vue'),
            meta: {
                title: 'Peculiarities Paddock'
            }
        },
        {
            path: '/nurseries',
            name:'nurseries',
            component: () => import('./Pages/Nurseries/Nurseries.vue'),
            meta: {
                title: 'Nurseries'
            }
        },
        {
            path: '/news',
            name:'news',
            component: () => import('./Pages/News/Index.vue'),
            meta: {
                title: 'News'
            }
        },
        {
            path: '/news/show',
            name:'news_show',
            component: () => import('./Pages/News/Show.vue'),
            meta: {
                title: 'News'
            }
        },
        {
            path: '/photos',
            name:'photos',
            component: () => import('./Pages/Media/Photo.vue'),
            meta: {
                title: 'Photos'
            }
        },
        {
            path: '/video',
            name:'video',
            component: () => import('./Pages/Media/Video.vue'),
            meta: {
                title: 'Video'
            }
        },
        {
            path: '/audio',
            name:'audio',
            component: () => import('./Pages/Media/Audio.vue'),
            meta: {
                title: 'Audio'
            }
        },
        {
            path: '/admin',
            name:'admin',
            component: () => import('./Pages/Admin/Index.vue'),
            meta: {
                middleware: [
                    verify_email,
                    admin
                ],
                title: 'Admin'
            }
        },
        {
            path: '/admin/users',
            name:'admin_users',
            component: () => import('./Pages/Admin/Users/Users.vue'),
            meta: {
                middleware: [
                    verify_email,
                    admin
                ],
                title: 'Admin-Users'
            }
        },
        {
            path: '/admin/user/edit/:user',
            name:'admin_user_edit',
            component: () => import('./Pages/Admin/Users/User.vue'),
            meta: {
                middleware: [
                    verify_email,
                    admin
                ],
                title: 'Admin-User'
            }
        },
        {
            path: '/admin/photos',
            name:'admin_photos',
            component: () => import('./Pages/Admin/Media/Photo.vue'),
            meta: {
                middleware: [
                    verify_email,
                    admin
                ],
                title: 'Admin-Photos'
            }
        },
        {
            path: '/admin/video',
            name:'admin_video',
            component: () => import('./Pages/Admin/Media/Video.vue'),
            meta: {
                middleware: [
                    verify_email,
                    admin
                ],
                title: 'Admin-Video'
            }
        },
        {
            path: '/admin/audio',
            name:'admin_audio',
            component: () => import('./Pages/Admin/Media/Audio.vue'),
            meta: {
                middleware: [
                    verify_email,
                    admin
                ],
                title: 'Admin-Audio'
            }
        }
    ]
})

router.beforeEach((to, from, next) => {
    if (!to.meta.middleware) {
        document.title = to.meta.title
        return next()
    }
    const middleware = to.meta.middleware;

    nextMiddleware(0, middleware, to, from, next)
})

export default router
