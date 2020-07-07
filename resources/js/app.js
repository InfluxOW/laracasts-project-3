require('./bootstrap');

import Vue from 'vue';
import VueConfirmDialog from 'vue-confirm-dialog'
import InstantSearch from 'vue-instantsearch';
import TurbolinksAdapter from 'vue-turbolinks';

/**
 * Our Vuejs event handler which we will be using for flash messaging
 * @type {Vue}
 */
window.events = new Vue();

/**
 * Our Flash function which will be used to add new flash events to our event handler
 *
 * @param  String message Our alert message
 * @param  String type    The type of alert we want to show
 */
window.flash = function (message, type) {
    window.events.$emit('flash', message, type);
};

Vue.use(VueConfirmDialog);
Vue.use(InstantSearch);
Vue.use(TurbolinksAdapter);

Vue.component('vue-confirm-dialog', VueConfirmDialog.default);
Vue.component('wysiwyg', require('./components/Wysiwyg.vue').default);
Vue.component('instant-search', require('./components/InstantSearch.vue').default);
Vue.component('file-uploader', require('./components/FileUploader.vue').default);
Vue.component('flash', require('./components/Flash.vue').default);
Vue.component('dropdown', require('./components/Dropdown.vue').default);
Vue.component('favorite', require('./components/Favorite.vue').default);
Vue.component('paginator', require('./components/Paginator.vue').default);
Vue.component('thread', require('./pages/Thread.vue').default);
Vue.component('profile', require('./pages/Profile.vue').default);
Vue.component('user-notifications', require('./components/UserNotifications.vue').default);

document.addEventListener('turbolinks:load', () => {
    const app = new Vue({
        el: '#app',
    });
});

let Turbolinks = require("turbolinks");
Turbolinks.start();

const ujs = require('@rails/ujs');
ujs.start();
