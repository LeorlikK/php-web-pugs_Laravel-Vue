export const API_ROUTES = {
    protected: {
        me: '/api/account/me',
        logout: '/api/account/logout'
    },
    public: {
        home: '/',
        login: '/api/account/login',
        registration: '/api/account/register',

        peculiarities: '/api/peculiarities',
        care: '/api/peculiarities/care',
        nutrition: '/api/peculiarities/nutrition',
        health: '/api/peculiarities/health',
        paddock: '/api/peculiarities/paddock',
    }
}
