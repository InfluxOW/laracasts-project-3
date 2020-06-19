require('./bootstrap');

import Vue from 'vue';

Vue.component('dropdown', require('./components/Dropdown.vue').default);
Vue.component('reply', require('./components/Reply.vue').default);

const app = new Vue({
    el: '#app',
});

const ujs = require('@rails/ujs');
ujs.start();


