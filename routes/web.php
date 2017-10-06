<?php

Route::get('/r', function() {
    return view('series');
});

Auth::routes();
Route::get('/', 'FrontendController@welcome');
Route::get('/watch-series/{series}', 'WatchSeriesController@index')->name('series.learning');
Route::get('/series/{series}/lesson/{lesson}', 'WatchSeriesController@showLesson')->name('series.watch');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/series/{series}', 'FrontendController@series')->name('series');
Route::get('/logout', function() { auth()->logout(); return redirect('/'); });
Route::get('register/confirm', 'ConfirmEmailController@index')->name('confirm-email');
