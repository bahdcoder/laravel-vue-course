<?php

namespace Bahdcasts;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $guarded = [];

    public function series() {
        return $this->belongsTo(Series::class);
    }

    public function getNextLesson() {
        return $this->series->lessons()->where('episode_number', '>', $this->episode_number)
                    ->orderBy('episode_number', 'asc')
                    ->first();
    }

    public function getPrevLesson() {
        return $this->series->lessons()->where('episode_number', '<', $this->episode_number)
                    ->orderBy('episode_number', 'desc')
                    ->first();
                    
    }
}
