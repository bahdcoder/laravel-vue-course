<?php

namespace Bahdcasts\Http\Controllers;

use Bahdcasts\Series;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function welcome() {
        return view('welcome')->withSeries(Series::all());
    }
}
