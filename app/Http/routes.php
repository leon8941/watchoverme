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
    //Route::get('test',['as' => 'test', 'uses' => 'UsersController@test']);

    Route::resource('events','EventsController');
    Route::resource('gamers','GamersController');
    Route::resource('teams','TeamsController');

    // Sitemaps
    Route::get('sitemap',['as' => 'sitemap', 'uses' => 'SitemapsController@index']);
    Route::get('sitemaps/general',['as' => 'sitemaps.general', 'uses' => 'SitemapsController@index']);
    Route::get('sitemaps/users',['as' => 'sitemaps.users', 'uses' => 'SitemapsController@users']);
    Route::get('sitemaps/posts',['as' => 'sitemaps.posts', 'uses' => 'SitemapsController@posts']);
    Route::get('sitemaps/teams',['as' => 'sitemaps.teams', 'uses' => 'SitemapsController@teams']);

    // Events
    Route::get('events.get',['as' => 'events.get', 'uses' => 'EventsController@get']);
});

//Route::auth();

Route::auth();

Route::group(['middleware' => ['auth']], function () {

    // Users
    Route::resource('users','UsersController');

    // User avatar upload
    Route::post('users/upload',['as' => 'users/upload', 'uses' => 'UsersController@upload']);
    Route::post('teams/upload',['as' => 'teams/upload', 'uses' => 'TeamsController@upload']);

    // Team request to join
    Route::get('teams.request',['as' => 'teams.request', 'uses' => 'TeamsController@request']);
    Route::get('teams.aproveRequest',['as' => 'teams.aproveRequest', 'uses' => 'TeamsController@aproveRequest']);

    // Create Team
    Route::get('teams/create',['as' => 'teams.create', 'uses' => 'TeamsController@create']);
});
