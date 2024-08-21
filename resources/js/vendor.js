/// Globals
import './bootstrap';

/// Packages
import 'bootstrap/dist/js/bootstrap.esm.min';
import '@fortawesome/fontawesome-free';
import 'flatpickr';

import sweetAlert from 'sweetalert';
window.sweetAlert = sweetAlert;

import moment from 'moment/moment';
window.moment = moment;

import { createApp } from 'vue/dist/vue.esm-bundler';
window.vueApp = createApp;

/// Helpers
import AlertHelper from './shared/helpers/AlertHelper';
window.AlertHelper = new AlertHelper;

import DateHelper from './shared/helpers/DateHelper';
window.DateHelper = new DateHelper;