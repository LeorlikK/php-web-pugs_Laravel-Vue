import indexStore  from '@/store/index.js'

export default function admin({ to, next}) {
    if (!indexStore.getters['authModule/getIsAdmin']) {
        to.meta.redirectRoute = 'home';
        return next(false)
    }

    return next()
}
