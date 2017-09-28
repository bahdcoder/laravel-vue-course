<?php 

Route::resource('series', 'SeriesController');
Route::resource('{series_by_id}/lessons', 'LessonsController');