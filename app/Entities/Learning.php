<?php 

namespace Bahdcasts\Entities;

use Redis;
use Bahdcasts\Series;
use Bahdcasts\Lesson;

trait Learning {
    /**
     * Mark a lesson as completed for a user
     *
     * @param [Bahdcasts\Lesson] $lesson
     * @return void
     */
    public function completeLesson($lesson) {
        Redis::sadd("user:{$this->id}:series:{$lesson->series->id}", $lesson->id);
    }

    /**
     * Get percentage completed for a series for a user
     *
     * @param [Bahdcasts\Series] $series
     * @return void
     */
    public function percentageCompletedForSeries($series) {
        $numberOfLessonsInSeries = $series->lessons->count();
        $numberOfCompletedLessons = $this->getNumberOfCompletedLessonsForASeries($series);

        return ($numberOfCompletedLessons / $numberOfLessonsInSeries) * 100;
    }

    /**
     * Get number of completed lessons for a series
     *
     * @param [Bahdcasts\Series] $series
     * @return void
     */
    public function getNumberOfCompletedLessonsForASeries($series) {
        return count($this->getCompletedLessonsForASeries($series));
    }

    /**
     * Get array of completed lessons ids for a series
     *
     * @param [Bahdcasts\Series] $series
     * @return array
     */
    public function getCompletedLessonsForASeries($series) {
        return Redis::smembers("user:{$this->id}:series:{$series->id}");
    }

    /**
     * Check if a user has started a series
     *
     * @param [Bahdcasts\Series] $series
     * @return boolean
     */
    public function hasStartedSeries($series) {
        return $this->getNumberOfCompletedLessonsForASeries($series) > 0;
    }

    /**
     * Get all completed lessons for a series
     *
     * @param [Bahdcasts\Series] $series
     * @return \Illuminate\Support\Collection(Bahdcasts\Lesson)
     */
    public function getCompletedLessons($series) {
        // 1, 2, 4
        return Lesson::whereIn('id', 
            $this->getCompletedLessonsForASeries($series)
        )->get();
    }

    /**
     * Check if user has completed a lesson
     *
     * @param [Bahdcasts\Lesson] $lesson
     * @return boolean
     */
    public function hasCompletedLesson($lesson) {
        return in_array(
            $lesson->id,
            $this->getCompletedLessonsForASeries($lesson->series)
        );
    }

    /**
     * Get all the series being watch ids
     *
     * @return array
     */
    public function seriesBeingWatchedIds() {
        $keys = Redis::keys("user:{$this->id}:series:*");
        $seriesIds = [];
        foreach($keys as $key):
            $seriedId = explode(':', $key)[3];
            array_push($seriesIds, $seriedId);
        endforeach;

        return $seriesIds;
    }

    /**
     * Get all the series a user is watching
     *
     * @return void
     */
    public function seriesBeingWatched() {
        return collect($this->seriesBeingWatchedIds())->map(function($id){
            return Series::find($id);
        })->filter();
    }

    /**
     * Get total number of lessons user has ever completed
     *
     * @return integer
     */
    public function getTotalNumberOfCompletedLessons() {
        $keys = Redis::keys("user:{$this->id}:series:*");
        $result = 0;
        foreach($keys as $key):
            $result = $result + count(Redis::smembers($key));
        endforeach;

        return $result;
    }

    /**
     * Get the next lesson the user should watch
     *
     * @param [Bahdcasts\Series] $series
     * @return Bahdcasts\Lesson
     */
    public function getNextLessonToWatch($series) {
        $lessonIds = $this->getCompletedLessonsForASeries($series);
        $lessonId = end($lessonIds);
        return Lesson::find(
            $lessonId
        )->getNextLesson();
    }
}