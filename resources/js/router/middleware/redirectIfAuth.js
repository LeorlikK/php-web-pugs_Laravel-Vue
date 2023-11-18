import indexStore  from '@/store/index.js'

export default function redirectIfAuth({ to, next}) {
    const arrayBlockRouteAfterAuth = ['login', 'registration']
    if (indexStore.getters['authModule/getIsAuth'] && arrayBlockRouteAfterAuth.includes(to.name)) {
        console.log('REDIRECT')
        to.meta.redirectRoute = 'home';
        return next(false)
    }

    return next()
}
