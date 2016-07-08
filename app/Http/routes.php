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

    // Users
    Route::resource('users','UsersController');
    Route::resource('events','EventsController');
    Route::resource('gamers','GamersController');
    Route::resource('posts','PostsController');

    //Route::get('posts.show',['as' => 'consult', 'uses' => 'PagesController@consult']);
});

//Route::auth();

Route::auth();

