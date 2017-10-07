<template>
  <div>
    <div :data-vimeo-id="lesson.video_id" data-vimeo-width="900" v-if="lesson" id="handstick"></div>
  </div>
</template>

<script>
    import Player from '@vimeo/player'
    export default {
        props: ['default_lesson'],
        data() {
            return {
                lesson: JSON.parse(this.default_lesson)
            }
        },
        mounted() {
            const player = new Player('handstick')

            player.on('play', () => {
                console.log('our video is playing !')
            })
        }
    }
</script>
