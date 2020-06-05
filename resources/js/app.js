require('./bootstrap');

import Vue from 'vue';

Vue.component('theme-switcher', require('./components/ThemeSwitcher.vue').default);
Vue.component('dropdown', require('./components/Dropdown.vue').default);


const app = new Vue({
    el: '#app',
});

const ujs = require('@rails/ujs');
ujs.start();

