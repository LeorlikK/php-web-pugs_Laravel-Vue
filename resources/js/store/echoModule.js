import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

export const echoModule = {
    namespaced: true,
    state: () => ({
        echo: null
    }),
    getters: {
        Echo: (state) => {
            if (!state.echo) {
                window.Pusher = Pusher;
                state.echo = new Echo({
                    broadcaster: 'pusher',
                    key: import.meta.env.VITE_PUSHER_APP_KEY,
                    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
                    wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
                    wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
                    wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
                    // forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
                    forceTLS: false,
                    enabledTransports: ['ws', 'wss'],
                });
            }
            return state.echo
        }
    },
    mutations: {


    },
    actions: {

    }
}
