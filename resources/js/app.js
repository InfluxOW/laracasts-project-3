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

window.FilePond = require('filepond');
window.FilePondPluginImagePreview = require('filepond-plugin-image-preview');
window.FilePondPluginImageValidateSize = require('filepond-plugin-image-validate-size');
window.FilePondPluginFileValidateType = require('filepond-plugin-file-validate-type');
window.FilePondPluginImageCrop = require('filepond-plugin-image-crop');
window.FilePondPluginImageTransform = require('filepond-plugin-image-transform');
window.FilePondPluginImageResize  = require('filepond-plugin-image-resize');
window.FilePondPluginFileEncode  = require('filepond-plugin-file-encode');
window.FilePondPluginImageExifOrientation   = require('filepond-plugin-image-exif-orientation');

FilePond.registerPlugin(
    FilePondPluginImagePreview,
    FilePondPluginImageValidateSize,
    FilePondPluginFileValidateType,
    FilePondPluginImageCrop,
    FilePondPluginImageResize,
    FilePondPluginImageTransform,
    FilePondPluginFileEncode,
    FilePondPluginImageExifOrientation
);

let Turbolinks = require("turbolinks");
Turbolinks.start();

const ujs = require('@rails/ujs');
ujs.start();
