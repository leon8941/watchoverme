<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => ['web']], function () {

    //Route::auth();

    Route::get('/',['as' => 'home', 'uses' => 'PagesController@soon']);


    Route::get('try',['as' => 'try', 'uses' => 'PagesController@home']);

    // Subscribe
    Route::post('pages.subscribe',['as' => 'pages.subscribe', 'uses' => 'PagesController@subscribe']);
});
