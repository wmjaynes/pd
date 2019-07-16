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

// Display all SQL executed in Eloquent
Event::listen('illuminate.query', function($query)
{
    var_dump($query);
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);


Route::get('/home', 'HomeController@index');
Route::get('/eventsfor/{organization}', 'EventController@show')->name('eventsfor.show');

Route::get('/events/{event}/copy', 'EventController@copy')->name('events.copy');
Route::post('/events/{event}/copy', 'EventController@copyStore')->name('events.copyStore');
Route::get('/events/{event}/publish', 'EventController@publish')->name('events.publish');
Route::get('/events/{event}/unpublish', 'EventController@unpublish')->name('events.unpublish');

Route::resource('events', 'EventController');
Route::resource('organization', 'OrganizationController');
Route::resource('venue', 'VenueController');


Route::get('/aggregate/{organization}', 'AggregateController@index')->name('aggregate.index');



Route::delete('/aggregate/{organization}', 'AggregateController@destroy')
    ->name('aggregate.destroy');
Route::post('/aggregate/{organization}', 'AggregateController@search')->name('aggregate.search');
Route::patch('/aggregate/{organization}', 'AggregateController@update')->name('aggregate.update');

Route::get('/user/{user}', 'UserController@show')->name('user.show');

Route::get('/administer/{organization}', 'AdministerController@show')->name('administer.org.show');
Route::post('/administer/{organization}', 'AdministerController@search')
    ->name('administer.org.search');
Route::delete('/administer/{organization}', 'AdministerController@destroy')
    ->name('administer.org.destroy');
Route::patch('/administer/{organization}', 'AdministerController@update')
    ->name('administer.org.update');

Route::get('/test/{organization}', 'TestController@test');


/*
 * Internal API routes. Called from within the application.
 */
Route::get('/organizations', "InternalApiController@getOrganizations");
Route::get('/aggregates/{organization}', 'InternalApiController@getAggregatesForOrganizations');
Route::get('/users/{user}/organizations', 'InternalApiController@getOrganizationsForUser');
Route::delete('/aggregates/{aggregate}/organizations/{organization}',
    'InternalApiController@detachOrganizationFromAggregate');
Route::put('/aggregates/{aggregate}/organizations/{organization}',
    'InternalApiController@attachOrganizationToAggregate');
Route::post('/organizations/{organization}/aggregates',
    'InternalApiController@createAggregateForOrganization');
Route::delete('/aggregates/{aggregate}',
    'InternalApiController@deleteAggregate');


//Route::prefix('api')->group(function () {
//    Route::get('events/{organization}/{aggrType}/{outputType}', 'ApiController@events');
//    Route::get('events/{organization}/{aggrType}/{outputType}/{period}/{extra?}',
//        'ApiController@eventsperiod')->where('period', '[[dwmy]|mm|yy|ymd]+')->where('extra',
//        '.*');
//
//    Route::get('event/{event}/{sublevels?}/', 'ApiController@event')->where('sublevels', '.*')
//        ->name('api.event');
//});

