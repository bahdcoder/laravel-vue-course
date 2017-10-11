<?php

namespace Bahdcasts;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    /**
     * All database columns to be guarded from mass assignment
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Eager load relationships
     *
     * @var array
     */
    protected $with = ['lessons'];

    /**
     * A series has many lessons
     *
     * @return void
     */
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

    /**
     * Return the public path for series image
     *
     * @return string
     */
    public function getImagePathAttribute() {
        return asset('storage/' . $this->image_url);
    }

    /**
     * Get a list of lessons for series in watching order
     *
     * @return void
     */
    public function getOrderedLessons() {
        return $this->lessons()->orderBy('episode_number', 'asc')->get();
    }
}
