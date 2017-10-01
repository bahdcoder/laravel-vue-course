<?php

namespace Bahdcasts;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $guarded = [];

    public function series() {
        return $this->belongsTo(Series::class);
    }
}
