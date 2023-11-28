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
        admin_photo_edit: '/api/admin/photo/edit',
        admin_photo_update: '/api/admin/photo/update',
        admin_photo_delete: '/api/admin/photo/delete',
        admin_video_store: '/api/admin/video/store',
        admin_video_edit: '/api/admin/video/edit',
        admin_video_update: '/api/admin/video/update',
        admin_video_delete: '/api/admin/video/delete',
        admin_audio_store: '/api/admin/audio/store',
        admin_audio_edit: '/api/admin/audio/edit',
        admin_audio_update: '/api/admin/audio/update',
        admin_audio_delete: '/api/admin/audio/delete',
        admin_news: '/api/admin/news',
        admin_news_store: '/api/news',
        admin_news_edit: '/api/news',
        admin_news_update: '/api/admin/news/update',
        admin_news_delete: '/api/news',
        admin_news_publish: '/api/admin/news/publish',
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
        news_show: '/api/news',

        comments: '/api/comments',

        photo: '/api/media/photo',
        video: '/api/media/video',
        audio: '/api/media/audio',
    }
}
