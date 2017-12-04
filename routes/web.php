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

Route::get('/incidents/{id}', 'IncidentsController@single');

Route::post('/incidents/create', 'IncidentsController@store')->name('share');

Route::get('/share', 'IncidentsController@create')->name('shareincident');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
