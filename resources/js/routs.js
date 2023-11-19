export const API_ROUTES = {
    protected: {
        me: '/api/account/me',
        updateMe: '/api/account/update',
        feedbackMe: '/api/account/feedback',
        comments_store: '/api/comments/store',
        comments_delete: '/api/comments/delete',
        admin_users: '/api/admin/users',
        admin_user_edit: '/api/admin/users/edit',
        admin_user_update: '/api/admin/users/update',
        admin_user_banned: '/api/admin/users/banned',
        admin_photo_store: '/api/admin/photo/store',
        admin_photo_delete: '/api/admin/photo/delete'
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

        photo: '/api/media/photo',
        video: '/api/media/video',
        audio: '/api/media/audio',
    }
}
