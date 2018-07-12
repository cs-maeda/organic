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

Route::domain('www.iacs-icc.dev')->group(function()
{
	Route::get('/',                                                     'iacsicc\IndexController@index');
	Route::get('/{prefecture}/{city?}/{townId?}',                       'iacsicc\IndexController@area');
	Route::get('/{prefecture}/{city}/station/{stationId}',              'iacsicc\IndexController@station');
// web api
    Route::get('/api/form/city/{prefectureId}',                         'ApiController@cityList');
    Route::get('/api/form/town/{cityId}',                               'ApiController@townList');
});

Route::domain('www.rhs-inc.dev')->group(function()
{
	Route::get('/',                                                     'rhsinc\IndexController@index');
	Route::get('/{prefecture}/{city?}/{townId?}',                       'rhsinc\IndexController@area');
    Route::get('/{prefecture}/{city}/station/{stationId}',              'rhsinc\IndexController@station');
// web api
    Route::get('/api/form/city/{prefectureId}',                         'ApiController@cityList');
    Route::get('/api/form/town/{cityId}',                               'ApiController@townList');
});


