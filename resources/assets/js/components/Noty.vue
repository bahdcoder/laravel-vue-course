<template>
	
</template>

<script>
	import Swal from 'sweetalert';
	export default {
		created() {
			window.events.$on('notification', (payload) => {
				Swal(payload.message);
			})
		}
	}
</script>