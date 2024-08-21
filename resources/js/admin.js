/// CSS
import '../sass/admin.scss';

/// Vendor
import './vendor';
import 'chart.js';

import Trix from 'trix';
window.trix = Trix;

/**
 * Register the API Token as a common header with Axios so that all outgoing HTTP requests
 * automatically have it attached. This is just a simple convenience so that we don't have to
 * attach every token manually.
 */
let api_token = document.head.querySelector('meta[name="api-token"]');

if (api_token) {
    window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + api_token.content;
}

// /**
//  * Echo exposes an expressive API for subscribing to channels and listening
//  * for events that are broadcast by Laravel. Echo and event broadcasting
//  * allows your team to easily build robust real-time web applications.
//  */
// import Pusher from 'pusher-js';
// window.Pusher = Pusher;
//
// import Echo from 'laravel-echo';
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_REVERB_APP_KEY,
//     cluster: '',
//     wsHost: import.meta.env.VITE_REVERB_HOST,
//     wsPort: import.meta.env.VITE_REVERB_PORT,
//     wssPort: import.meta.env.VITE_REVERB_PORT,
//     forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
//     encrypted: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
//     disableStats: true,
//     enabledTransports: ['ws', 'wss'],
//     auth: {
//         headers: {
//             'Authorization': (api_token ? ('Bearer ' + api_token.content) : null),
//         }
//     }
// });

/// Custom
import './admin/custom';

/// Vue Components
//import ExampleComponent from './admin/components/ExampleComponent.vue';
import BootstrapTheme from './admin/components/BootstrapTheme.vue';

const app = vueApp({});
//app.component('example-component', ExampleComponent);
app.component('bs-theme-admin', BootstrapTheme);
app.mount('#app');