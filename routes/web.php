<?php

Auth::routes();
Route::get('/', 'FrontendController@welcome');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile/{user}', 'ProfilesController@index')->name('profile');
Route::get('/series/{series}', 'FrontendController@series')->name('series');
Route::get('/logout', function() { auth()->logout(); return redirect('/'); });
Route::get('/series', 'FrontendController@showAllseries')->name('all-series');
Route::get('register/confirm', 'ConfirmEmailController@index')->name('confirm-email');


Route::middleware('auth')->group(function() {
    Route::post('/card/update', 'ProfilesController@updateCard');
    Route::post('/subscribe', 'SubscriptionsController@subscribe');    
    Route::post('/subscription/change', 'SubscriptionsController@change')->name('subscriptions.change');        
    Route::get('/subscribe', 'SubscriptionsController@showSubscriptionForm');
    Route::post('/series/complete-lesson/{lesson}', 'WatchSeriesController@completeLesson');
    Route::get('/watch-series/{series}', 'WatchSeriesController@index')->name('series.learning');
    Route::get('/series/{series}/lesson/{lesson}', 'WatchSeriesController@showLesson')->name('series.watch');
});
