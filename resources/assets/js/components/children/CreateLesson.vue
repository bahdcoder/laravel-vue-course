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
	              <input type="text" class="form-control" placeholder="Lesson title" v-model="lesson.title">
	            </div>
	            <div class="form-group">
	              <input type="text" class="form-control" placeholder="Vimeo video id" v-model="lesson.video_id">
	            </div>
	            <div class="form-group">
	              <input type="number" class="form-control" placeholder="Episode number" v-model="lesson.episode_number">
	            </div>

	            <div class="form-group">
	            	<textarea cols="30" rows="10" class="form-control" v-model="lesson.description"></textarea>
	            </div>
							<div class="form-group">
	            	<input type="checkbox" v-model="lesson.premium"> Premium: {{ lesson.premium }}
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

	class Lesson {
		constructor(lesson) {
			this.title = lesson.title || ''
			this.description = lesson.description || ''
			this.video_id = lesson.video_id || ''
			this.episode_number = lesson.episode_number || ''
			this.premium = lesson.premium || false 
		}
	}

	export default {
		mounted() {
			this.$parent.$on('create_new_lesson', (seriesId) => {
				this.seriesId = seriesId
				this.editing = false
				this.lesson = new Lesson({}) 
				$('#createLesson').modal()
			})

			this.$parent.$on('edit_lesson', ({ lesson, seriesId }) => {
				this.editing = true 
				this.lesson = new Lesson(lesson)
				this.seriesId = seriesId
				this.lessonId = lesson.id 

				$('#createLesson').modal()
			})
		}, 
		data() {
			return {
				lesson: {},
				seriesId: '',
				editing: false,
				lessonId: null,
				premium: false 
			}
		},
		methods: {
			createLesson() {
				Axios.post(`/admin/${this.seriesId}/lessons`, this.lesson).then(resp => {
					this.$parent.$emit('lesson_created', resp.data)
					$('#createLesson').modal('hide')
				}).catch(error => {
					window.handleErrors(error)
				})
			}, 
			updateLesson() {
				Axios.put(`/admin/${this.seriesId}/lessons/${this.lessonId}`, this.lesson)
				 .then(resp => {
				 	$("#createLesson").modal('hide')
				 	this.$parent.$emit('lesson_updated', resp.data)
				 }).catch(error => {
				 	window.handleErrors(error)
				 })
			}
		}
	}
</script>