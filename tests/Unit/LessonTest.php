<?php

namespace Tests\Unit;

use Tests\TestCase;
use Bahdcasts\Series;
use Bahdcasts\Lesson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LessonTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_can_get_next_and_previous_lessons_from_a_lesson() {
        // series of lessons 
        $lesson = factory(Lesson::class)->create(['episode_number' => 200]);
        $lesson2 = factory(Lesson::class)->create(['episode_number' => 100, 'series_id' => 1]);
        $lesson3 = factory(Lesson::class)->create(['episode_number' => 300, 'series_id' => 1]);
        // get next lesson, and get prev lesson
        $this->assertEquals($lesson->getNextLesson()->id, $lesson3->id);
        $this->assertEquals($lesson3->getPrevLesson()->id, $lesson->id);
        $this->assertEquals($lesson2->getNextLesson()->id, $lesson->id);
        $this->assertEquals($lesson2->getPrevLesson()->id, $lesson2->id);
        $this->assertEquals($lesson3->getNextLesson()->id, $lesson3->id);
    }
}
