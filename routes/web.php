<?php

Route::get('/r', function() {
    dd(Redis::command('keys', '*'));
});

Auth::routes();
Route::get('/', 'FrontendController@welcome');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/logout', function() { auth()->logout(); return redirect('/'); });
Route::get('register/confirm', 'ConfirmEmailController@index')->name('confirm-email');
