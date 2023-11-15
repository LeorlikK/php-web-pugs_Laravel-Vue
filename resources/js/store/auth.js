export const auth = {
    state: () => ({
        isAuth: false,
        login: '',
        role: 'admin',
        verify: true,
    }),
    getters: {
        getIsAuth: state => state.isAuth,
        getLogin: state => state.login,
        getAdmin: state => state.role === 'admin',
        getVerify: state => state.verify,
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
