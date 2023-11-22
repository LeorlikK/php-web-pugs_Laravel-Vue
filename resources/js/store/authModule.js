export const authModule = {
    namespaced: true,
    state: () => ({
        user: null,
        token: null,
    }),
    getters: {
        getId: state => state.user?.id,
        getLogin: state => state.user?.login,
        getIsAuth: state => state.user !== null && state.token !== null,
        getIsAdmin: state => state.user?.role === 'admin',
        getIsVerify: state => state.user !== null && state.user.email_verified_at !== null,
    },
    mutations: {
        changeUser(state, user) {
            state.user = user
        },
        changeToken(state, token) {
            state.token = token
        },
    },
    actions: {

    }
}
