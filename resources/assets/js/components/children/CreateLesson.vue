<template>
	<div class="modal fade" id="createLesson" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	    <div class="modal-dialog" role="document">
	      <div class="modal-content">
	        <div class="modal-header">
	          <h5 class="modal-title" id="exampleModalLabel">Create new lesson</h5>
	          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	            <span aria-hidden="true">&times;</span>
	          </button>
	        </div>
	        <div class="modal-body">
		         <div class="form-group">
	              <input type="text" class="form-control" placeholder="Lesson title" v-model="title">
	            </div>
	            <div class="form-group">
	              <input type="text" class="form-control" placeholder="Vimeo video id" v-model="video_id">
	            </div>
	            <div class="form-group">
	              <input type="number" class="form-control" placeholder="Episode number" v-model="episode_number">
	            </div>

	            <div class="form-group">
	            	<textarea cols="30" rows="10" class="form-control" v-model="description"></textarea>
	            </div>
	        </div>
	        <div class="modal-footer">
	          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	          <button type="button" class="btn btn-primary" @click="updateLesson()" v-if="editing">Save lesson</button>
	          <button type="button" class="btn btn-primary" @click="createLesson()" v-else>Create lesson</button>
	        </div>
	      </div>
	    </div>
	  </div>
</template>

<script>
	import Axios from 'axios'

	export default {
		mounted() {
			this.$parent.$on('create_new_lesson', (seriesId) => {
				this.seriesId = seriesId
				console.log('hello parent, we are creating the lesson.')
				$('#createLesson').modal()
			})

			this.$parent.$on('edit_lesson', ({ lesson, seriesId }) => {
				this.editing = true 
				this.title = lesson.title
				this.description = lesson.description
				this.video_id = lesson.video_id
				this.seriesId = seriesId
				this.lessonId = lesson.id 
				this.episode_number = +lesson.episode_number

				$('#createLesson').modal()
			})
		}, 
		data() {
			return {
				title: '',
				description: '',
				episode_number: 0,
				video_id: '',
				seriesId: '',
				editing: false,
				lessonId: null 
			}
		},
		methods: {
			createLesson() {
				Axios.post(`/admin/${this.seriesId}/lessons`, {
					title: this.title,
					description: this.description,
					episode_number: this.episode_number,
					video_id: this.video_id
				}).then(resp => {
					this.$parent.$emit('lesson_created', resp.data)
					$('#createLesson').modal('hide')
				}).catch(resp => {
					console.log(resp)
				})
			}, 
			updateLesson() {
				Axios.put(`/admin/${this.seriesId}/lessons/${this.lessonId}`, {
					title: this.title,
					description: this.description,
					episode_number: this.episode_number,
					video_id: this.video_id
				})
				 .then(resp => {
				 	console.log(resp)
				 }).catch(resp => {
				 	console.log(resp)
				 })
			}
		}
	}
</script>