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

    public function test_can_know_if_a_user_has_started_a_series() {
        //user, 2 series,
        $this->flushRedis();
        $user = factory(User::class)->create();
        $lesson = factory(Lesson::class)->create();
        $lesson2 = factory(Lesson::class)->create([
            'series_id' => 1
        ]);
        $lesson3 = factory(Lesson::class)->create();
        //user watches a lesson in the 1st series
        $user->completeLesson($lesson2);
        // assert that returns true hasStartedseries(1)
        $this->assertTrue($user->hasStartedSeries($lesson->series));
        $this->assertFalse($user->hasStartedSeries($lesson3->series));
    }

    public function test_can_get_completed_lessons_for_a_series() {
        // user , series
        $this->flushRedis();
        $user = factory(User::class)->create();
        $lesson = factory(Lesson::class)->create();
        $lesson2 = factory(Lesson::class)->create([ 'series_id' => 1 ]);
        $lesson3 = factory(Lesson::class)->create([ 'series_id' => 1 ]);
        //completes some lessons in the series
        $user->completeLesson($lesson);
        $user->completeLesson($lesson2);
        //get completed lessons method 
        $completedLessons = $user->getCompletedLessons($lesson->series);
        //assert that the lessons completed are in the return value 
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $completedLessons);
        $this->assertInstanceOf(Lesson::class, $completedLessons->random());
        $completedLessonsIds = $completedLessons->pluck('id')->all();
        $this->assertTrue(in_array($lesson->id, $completedLessonsIds));
        $this->assertTrue(in_array($lesson2->id, $completedLessonsIds ));
        $this->assertFalse(in_array($lesson3->id, $completedLessonsIds));
    }

    public function test_can_check_if_user_has_completed_lesson() {
        $this->flushRedis();
        $user = factory(User::class)->create();
        $lesson = factory(Lesson::class)->create();
        $lesson2 = factory(Lesson::class)->create([ 'series_id' => 1 ]);
        //complete a lesson 
        $user->completeLesson($lesson);
        //assert true, 
        $this->assertTrue($user->hasCompletedLesson($lesson));
        $this->assertFalse($user->hasCompletedLesson($lesson2));
    }

    public function test_can_get_all_series_being_watched_by_user() {
        $this->flushRedis();
        $user = factory(User::class)->create();
        $lesson = factory(Lesson::class)->create();
        $lesson2 = factory(Lesson::class)->create([ 'series_id' => 1 ]);
        $lesson3 = factory(Lesson::class)->create();
        $lesson4 = factory(Lesson::class)->create([ 'series_id' => 2 ]);
        $lesson5 = factory(Lesson::class)->create();
        $lesson6 = factory(Lesson::class)->create([ 'series_id' => 3 ]);
        // complete lesson 1 , 2 
        $user->completeLesson($lesson);
        $user->completeLesson($lesson3);

        $startedSeries = $user->seriesBeingWatched();
        // collection of series
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $startedSeries);
        $this->assertInstanceOf(\Bahdcasts\Series::class, $startedSeries->random());
        $idsOfStartedSeries = $startedSeries->pluck('id')->all();

        $this->assertTrue(
            in_array($lesson->series->id, $idsOfStartedSeries)
        );
        $this->assertTrue(
            in_array($lesson3->series->id, $idsOfStartedSeries)
        );
        $this->assertFalse(
            in_array($lesson6->series->id, $idsOfStartedSeries)
        );
        //assert 1 , 2
        // assert 3 
    }

    public function test_can_get_number_of_completed_lessons_for_a_user() {
        //user 
        $this->flushRedis();
        $user = factory(User::class)->create();
        $lesson = factory(Lesson::class)->create();
        $lesson2 = factory(Lesson::class)->create([ 'series_id' => 1 ]);
        $lesson3 = factory(Lesson::class)->create();
        $lesson4 = factory(Lesson::class)->create([ 'series_id' => 2 ]);
        $lesson5 = factory(Lesson::class)->create([ 'series_id' => 2 ]);

        $user->completeLesson($lesson);
        $user->completeLesson($lesson3);
        $user->completeLesson($lesson5);

        $this->assertEquals(3, $user->getTotalNumberOfCompletedLessons());
    }
    
    public function test_can_get_next_lesson_to_be_watched_by_user() {
        $this->flushRedis();
        $user = factory(User::class)->create();
        $lesson = factory(Lesson::class)->create([ 'episode_number' => 100 ]);
        $lesson2 = factory(Lesson::class)->create([ 'series_id' => 1, 'episode_number' => 200 ]);
        $lesson3 = factory(Lesson::class)->create([ 'series_id' => 1, 'episode_number' => 300 ]);
        $lesson4 = factory(Lesson::class)->create([ 'series_id' => 1, 'episode_number' => 400 ]);
        $user->completeLesson($lesson);
        $user->completeLesson($lesson2);

        $nextLesson = $user->getNextLessonToWatch($lesson->series);
        $this->assertEquals($lesson3->id, $nextLesson->id);
        $user->completeLesson($lesson3);
        $this->assertEquals($lesson4->id, $user->getNextLessonToWatch($lesson->series)->id);
    }
}
