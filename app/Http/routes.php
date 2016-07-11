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

    Route::get('/',['as' => 'home', 'uses' => 'PagesController@home']);
    Route::get('home',['as' => 'home', 'uses' => 'PagesController@home']);

    // API consuming
    Route::get('consult',['as' => 'consult', 'uses' => 'PagesController@consult']);

    // Subscribe
    Route::post('pages.subscribe',['as' => 'pages.subscribe', 'uses' => 'PagesController@subscribe']);


    Route::resource('posts','PostsController');

    Route::get('gamers.activate',['as' => 'gamers.activate', 'uses' => 'GamersController@activate']);
    Route::get('test',['as' => 'test', 'uses' => 'UsersController@test']);
});

//Route::auth();

Route::auth();

Route::group(['middleware' => ['auth']], function () {

    // Users
    Route::resource('users','UsersController');
    Route::resource('events','EventsController');
    Route::resource('gamers','GamersController');
});
