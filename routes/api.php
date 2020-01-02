<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
// */




/**
 * Admin
 */


Route::group(['middleware' => 'api','prefix' => 'admin'], function ($router) {
    Route::post('login', 'Admin\AuthController@login');
    Route::post('register', 'Admin\AuthController@register');

    Route::post('logout', 'Admin\AuthController@logout');
    Route::post('profile', 'Admin\AuthController@me');
});

Route::name('verify')->get('admin/verify/{token}' , 'Admin\AuthController@verify');
Route::name('resend')->get('admin/{user}/resend' , 'Admin\AuthController@resend');



/**
 * User
 */

Route::group(['middleware' => 'api','prefix' => 'user'], function ($router) {
    Route::post('login', 'User\AuthController@login');
    Route::post('register', 'User\AuthController@register');

    Route::post('logout', 'User\AuthController@logout');
    Route::post('profile', 'User\AuthController@me');
});




Route::group(['middleware' => 'auth:' . ADMIN_GUARD], function () {
/**
 * Plans
 */
    Route::group(['prefix' => 'plans'], function () {
        Route::post('/', ['as' => 'plan.store', 'uses' => 'Plan\PlanController@store']);
        Route::match(["POST", "PUT"], '/{plan}', ['as' => 'plan.update', 'uses' => 'Plan\PlanController@update']);
        Route::get('/', ['as' => 'plan.index', 'uses' => 'Plan\PlanController@index']);
        Route::get('/{id}', ['as' => 'plan.show', 'uses' => 'Plan\PlanController@show'])->where('id', '[0-9]+');;
        Route::delete('/{plan}', ['as' => 'plans.delete', 'uses' => 'Plan\PlanController@destroy']);
        Route::post('/{plan}/{active}', ['as' => 'plan.change.active', 'uses' => 'Plan\PlanController@changeStatus']);
    });


    /**
 * Constant
 */
Route::group(['prefix' => 'constants'], function () {
    Route::post('/', ['as' => 'constant.store', 'uses' => 'Constant\ConstantController@store']);
    Route::match(["POST", "PUT"], '/{constant}', ['as' => 'constant.update', 'uses' => 'Constant\ConstantController@update']);
    Route::get('/', ['as' => 'constant.index', 'uses' => 'Constant\ConstantController@index']);
    Route::get('/{id}', ['as' => 'constant.show', 'uses' => 'Constant\ConstantController@show'])->where('id', '[0-9]+');;
    Route::delete('/{constant}', ['as' => 'constant.delete', 'uses' => 'Constant\ConstantController@destroy']);
    Route::post('/{constant}/{active}', ['as' => 'constant.change.active', 'uses' => 'Constant\ConstantController@changeStatus']);
});
});
