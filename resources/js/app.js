require('./bootstrap');

import Vue from 'vue';

Vue.prototype.authorize = function (handler) {
    // Additional admin privileges here.
    let user = window.app.user;

    return user ? handler(user) : false;
};

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
window.flash = function(message, type) {
    window.events.$emit('flash', message, type);
};

Vue.component('flash', require('./components/Flash.vue').default);
Vue.component('dropdown', require('./components/Dropdown.vue').default);
Vue.component('favorite', require('./components/Favorite.vue').default);
Vue.component('paginator', require('./components/Paginator.vue').default);
Vue.component('thread', require('./pages/Thread.vue').default);
Vue.component('user-notifications', require('./components/UserNotifications.vue').default);

const app = new Vue({
    el: '#app',
});

const ujs = require('@rails/ujs');
ujs.start();
