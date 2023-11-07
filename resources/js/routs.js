export const API_ROUTES = {
    protected: {
        me: '/api/account/me',
        updateMe: '/api/account/update',
        comments_store: '/api/comments/store',
        comments_delete: '/api/comments/delete',
    },
    public: {
        home: '/',
        login: '/api/account/login',
        logout: '/api/account/logout',
        registration: '/api/account/registration',

        peculiarities: '/api/peculiarities',
        care: '/api/peculiarities/care',
        nutrition: '/api/peculiarities/nutrition',
        health: '/api/peculiarities/health',
        paddock: '/api/peculiarities/paddock',

        nurseries: '/api/nurseries',

        news: '/api/news',
        news_show: '/api/news/show',

        comments: '/api/comments',

        photos: '/api/media/photo',
        video: '/api/media/video',
        audio: '/api/media/audio',
    }
}
