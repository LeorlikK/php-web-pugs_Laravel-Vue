export const auth = {
    state: () => ({
        isAuth: false,
        login: ''
    }),
    getters: {
        getIsAuth: state => state.isAuth,
        getLogin: state => state.login,
    },
    mutations: {
        changeIsAuth(state, flag) {
            state.isAuth = flag
        },
        changeLogin(state, login) {
            state.login = login
        },
    },
    actions: {

    }
}
