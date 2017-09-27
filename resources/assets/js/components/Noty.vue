<template>
	<div class="alert" style="width: 400px; position: fixed; right: 25px; bottom: 25px;" 
		:class="type" v-if="notification">
		<p class="text-center">{{ notification.message }} </p>
	</div>
</template>

<script>
	export default {
		created() {
			window.events.$on('notification', (payload) => {
				this.notification = payload
				setTimeout(() => {
					this.notification = null
				}, 2500)
			})
		},
		data() {
			return {
				notification: this.default_noty || null 
			}
		},
		computed: {
			type() {
				return `alert-${this.notification.type}`
			}
		}
	}
</script>