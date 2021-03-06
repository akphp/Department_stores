<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    return view('welcome');
});


// Auth::routes(['register' => false , 'password.*' => false]);

Route::get('login' , 'Auth\LoginController@showLoginForm')->name('login');



// login with Social Media
Route::get('login/{provider}', 'User\LoginSocialiteController@redirectToProvider');
Route::get('login/{provider}/callback', 'User\LoginSocialiteController@callback');
