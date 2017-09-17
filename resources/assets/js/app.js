
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

window.events = new Vue() 

window.noty = function(notification) {
	window.events.$emit('notification', notification)
}


Vue.component('vue-noty', require('./components/Noty.vue'))
Vue.component('vue-login', require('./components/Login.vue'))
Vue.component('vue-lessons', require('./components/Lessons.vue'))
const app = new Vue({
    el: '#app'
});
