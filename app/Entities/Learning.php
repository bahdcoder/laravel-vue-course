<?php 

namespace Bahdcasts\Entities;

use Redis;

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
        return count(Redis::smembers("user:{$this->id}:series:{$series->id}"));
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
}