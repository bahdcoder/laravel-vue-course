
require('./bootstrap');

window.Vue = require('vue');

window.events = new Vue() 

window.noty = function(notification) {
	window.events.$emit('notification', notification)
}

window.handleErrors = function(error) {
	if(error.response.status == 422) {
 		window.noty({
			message: 'You had validation errors. Please try again.',
			type: 'danger'
		})
 	}

 	window.noty({
		message: 'Something went wrong . Please refresh the page.',
		type: 'danger'
	})
}


Vue.component('vue-noty', require('./components/Noty.vue'))
Vue.component('vue-login', require('./components/Login.vue'))
Vue.component('vue-stripe', require('./components/Stripe.vue'))
Vue.component('vue-player', require('./components/Player.vue'))
Vue.component('vue-lessons', require('./components/Lessons.vue'))
Vue.component('vue-update-card', require('./components/UpdateCard.vue'));
const app = new Vue({
    el: '#app'
});
