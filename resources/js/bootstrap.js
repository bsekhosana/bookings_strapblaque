import _ from 'lodash';
window._ = _;

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

import jquery from 'jquery';

try {
    window.$ = window.jQuery = jquery;
} catch (e) {
    console.log('Failed to load jQuery!');
}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Register the CSRF Token as a common header with Axios so that all outgoing HTTP requests
 * automatically have it attached. This is just a simple convenience so that we don't have to
 * attach every token manually.
 */
let csrf_token = document.head.querySelector('meta[name="csrf-token"]');

if (csrf_token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = csrf_token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}