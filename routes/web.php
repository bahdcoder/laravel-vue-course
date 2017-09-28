<?php

Route::get('/', 'FrontendController@welcome');

Route::get('register/confirm', 'ConfirmEmailController@index')->name('confirm-email');
Route::get('/logout', function() { auth()->logout(); return redirect('/'); });
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
