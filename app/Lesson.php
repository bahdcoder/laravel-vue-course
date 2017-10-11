<?php

namespace Bahdcasts;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    /**
     * Fields for mass assignment
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * A lesson belongs to a series
     *
     * @return void
     */
    public function series() {
        return $this->belongsTo(Series::class);
    }

    /**
     * Get next lesson after $this 
     *
     * @return \Bahdcasts\Lesson
     */
    public function getNextLesson() {
        return $this->series->lessons()->where('episode_number', '>', $this->episode_number)
                    ->orderBy('episode_number', 'asc')
                    ->first();
    }

    /**
     * Get previous lesson for $this
     *
     * @return \Bahdcasts\Lesson
     */
    public function getPrevLesson() {
        return $this->series->lessons()->where('episode_number', '<', $this->episode_number)
                    ->orderBy('episode_number', 'desc')
                    ->first();
                    
    }
}
