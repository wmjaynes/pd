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

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/eventsfor/{organization}', 'EventController@show')->name('eventsfor.show');

Route::get('/events/{event}/copy', 'EventController@copy')->name('events.copy');

Route::resource('events', 'EventController');
Route::resource('organization', 'OrganizationController');
Route::resource('venue', 'VenueController');

Route::get('/aggregate/{organization}', 'AggregateController@index')->name('aggregate.index');
Route::delete('/aggregate/{organization}', 'AggregateController@destroy')->name('aggregate.destroy');
Route::post('/aggregate/{organization}', 'AggregateController@search')->name('aggregate.search');
Route::patch('/aggregate/{organization}', 'AggregateController@update')->name('aggregate.update');

Route::get('/user/{user}', 'UserController@show')->name('user.show');

Route::get('/administer/{organization}', 'AdministerController@show')->name('administer.org.show');
Route::post('/administer/{organization}', 'AdministerController@search')->name('administer.org.search');
Route::delete('/administer/{organization}', 'AdministerController@destroy')->name('administer.org.destroy');
Route::patch('/administer/{organization}', 'AdministerController@update')->name('administer.org.update');
