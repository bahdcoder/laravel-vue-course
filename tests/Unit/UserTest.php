<?php

namespace Tests\Unit;

use Redis;
use Tests\TestCase;
use Bahdcasts\User;
use Bahdcasts\Lesson;
use Bahdcasts\Series;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_complete_a_lesson() {
        $this->flushRedis();
        $user = factory(User::class)->create();
        $lesson = factory(Lesson::class)->create();
        $lesson2 = factory(Lesson::class)->create([
            'series_id' => 1
        ]);
        $user->completeLesson($lesson);
        $user->completeLesson($lesson2);
        $this->assertEquals(
            Redis::smembers('user:1:series:1'),
            [1, 2]
        );

        $this->assertEquals(
            $user->getNumberOfCompletedLessonsForASeries($lesson->series),
            2
        );
    }

    public function test_can_get_percentage_completed_for_series_for_a_user() {
        $this->flushRedis();
        $user = factory(User::class)->create();
        $lesson = factory(Lesson::class)->create();
        factory(Lesson::class)->create(['series_id' => 1]);
        factory(Lesson::class)->create(['series_id' => 1]);
        $lesson2 = factory(Lesson::class)->create([
            'series_id' => 1
        ]);
        $user->completeLesson($lesson);
        $user->completeLesson($lesson2);

        $this->assertEquals(
            $user->percentageCompletedForSeries($lesson->series),
            50
        );
    }
}
