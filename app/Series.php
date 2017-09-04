<?php

namespace Bahdcasts;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $guarded = [];

    protected $with = ['lessons'];


    public function lessons()
    {
    	return $this->hasMany(Lesson::class);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
