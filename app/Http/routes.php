<?php

Route::get('/', 'WelcomeController@index');

Route::get('home', ['uses' => 'HomeController@index', 'as' => 'home']);

Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Just for friends..

//Route::get('auth/register', 'Auth\AuthController@getRegister');
//Route::post('auth/register', 'Auth\AuthController@postRegister');

//Route::get('password/email', 'Auth\PasswordController@getEmail');
//Route::post('password/email', 'Auth\PasswordController@postEmail');
//Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
//Route::post('password/reset', 'Auth\PasswordController@postReset');

Route::get('compare', ['uses' => 'CompareController@index', 'as' => 'compare']);

Route::resource('courses', 'CourseController', ['only' => ['index', 'show']]);

Route::resource('courses.holes', 'CourseHoleController', ['only' => ['show']]);

Route::get('users/{users}/feed', ['uses' => 'UserController@feed', 'as' => 'users.feed']);
Route::post('users/{users}/follow', ['uses' => 'UserController@follow', 'as' => 'users.follow']);
Route::post('users/{users}/unfollow', ['uses' => 'UserController@unfollow', 'as' => 'users.unfollow']);
Route::get('users/{users}/following', ['uses' => 'UserController@following', 'as' => 'users.following']);
Route::get('users/{users}/followers', ['uses' => 'UserController@followers', 'as' => 'users.followers']);
Route::get('users/{users}/rounds', ['uses' => 'UserController@rounds', 'as' => 'users.rounds']);
Route::resource('users', 'UserController', ['only' => ['index', 'show']]);

Route::resource('rounds', 'RoundController');