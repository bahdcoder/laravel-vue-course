<?php

namespace Bahdcasts;

use Redis;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'confirm_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Checks if user's email has been confirmed
     *
     * @return boolean
     */
    public function isConfirmed()
    {
        return $this->confirm_token == null;
    }

    /**
     * Confirm a user's email
     *
     * @return void
     */
    public function confirm() 
    {
        $this->confirm_token = null;
        $this->save();
    }

    /**
     * Check if current user is an administrator
     *
     * @return boolean
     */
    public function isAdmin()
    {
        return in_array($this->email, config('bahdcasts.administrators'));
    }

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
}
