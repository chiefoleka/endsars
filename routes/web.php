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

Route::get('/', 'IncidentsController@index')->name('homepage');

Route::get('/privacy', 'HomeController@privacy')->name('privacy');

Route::get('/terms', 'HomeController@terms')->name('terms');

Route::get('/getTweets', 'IncidentsController@tweets');

Route::get('/stories', 'IncidentsController@stories');

Route::get('/fetchOldTweets', 'IncidentsController@oldTweets');

Route::get('/chartdata', 'IncidentsController@chartData');

Route::get('/getTweets', 'IncidentsController@tweets');

Route::post('/deleteTweet', 'IncidentsController@deleteTweet');

Route::post('/addActions', 'IncidentsController@addActions');

Route::get('/getOldTweets/{id}', 'TweetsController@tweetsSince');

Route::get('/getOldTweets', 'TweetsController@tweetsSince');

Route::get('/getVideos', 'TweetsController@youtubeVideo');

Route::get('/incidents/{id}', 'IncidentsController@single');

Route::post('/incidents/create', 'IncidentsController@store')->name('share');

Route::post('/incidents/createback', 'IncidentsController@createback')->name('createback');

Route::get('/share', 'IncidentsController@create')->name('shareincident');

Route::get('/createback', 'IncidentsController@createhidden');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/deleteTweets', 'HomeController@deleteTweets');
