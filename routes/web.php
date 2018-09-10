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

Route::domain(env('APP_IACS_ICC_DOMAIN'))->group(function()
//Route::domain('dev.iacs-icc.org')->group(function()
{
// for test -->
    Route::get('/test/{num}',                                           'ApiController@unitTest');
// <-- for test
// web api -->
    Route::get('/api/sitemap/',                                         'ApiController@iacsiccSitemap');
    Route::get('/api/form/city/{prefectureId}',                         'ApiController@cityList');
    Route::get('/api/form/town/{cityId}',                               'ApiController@townList');
    Route::get('/api/trade/prefecture/{id}/{pageNum}/{action}',         'ApiController@prefectureTradeRecords');
    Route::get('/api/trade/city/{id}/{pageNum}/{action}',               'ApiController@cityTradeRecords');
    Route::get('/api/trade/town/{id}/{pageNum}/{action}',               'ApiController@townTradeRecords');
    Route::get('/api/trade/station/{id}/{pageNum}/{action}',            'ApiController@stationTradeRecords');
    Route::get('/api/link/exist/{prefecture?}/{city?}/{townId?}',       'ApiController@linkExists');
    Route::get('/api/link/exist/{prefecture}/{city}/station/{stationId}','ApiController@stationLinkExists');
// <-- web api

    Route::get('/',                                                     'iacsicc\IndexController@index');
    Route::get('/{prefecture}/{city?}/{townId?}',                       'iacsicc\IndexController@area');
    Route::get('/{prefecture}/{city}/station/{stationId}',              'iacsicc\IndexController@station');
});

Route::domain(env('APP_RHS_INC_DOMAIN'))->group(function()
//Route::domain('dev.rhs-inc.com')->group(function()
{
// for test -->
    Route::get('/test/{num}',                                           'ApiController@unitTest');
// <-- for test
// web api -->
    Route::get('/api/sitemap/',                                         'ApiController@rhsincSitemap');
    Route::get('/api/form/city/{prefectureId}',                         'ApiController@cityList');
    Route::get('/api/form/town/{cityId}',                               'ApiController@townList');
    Route::get('/api/trade/prefecture/{id}/{pageNum}/{action}',         'ApiController@prefectureTradeRecords');
    Route::get('/api/trade/city/{id}/{pageNum}/{action}',               'ApiController@cityTradeRecords');
    Route::get('/api/trade/town/{id}/{pageNum}/{action}',               'ApiController@townTradeRecords');
    Route::get('/api/trade/station/{id}/{pageNum}/{action}',            'ApiController@stationTradeRecords');
    Route::get('/api/link/exist/{prefecture?}/{city?}/{townId?}',       'ApiController@linkExists');
    Route::get('/api/link/exist/{prefecture}/{city}/station/{stationId}','ApiController@stationLinkExists');
// <-- web api

    Route::get('/',                                                     'rhsinc\IndexController@index');
    Route::get('/{prefecture}/{city?}/{townId?}',                       'rhsinc\IndexController@area');
    Route::get('/{prefecture}/{city}/station/{stationId}',              'rhsinc\IndexController@station');
});

Route::domain(env('APP_GINATONIC_DOMAIN'))->group(function()
{
// for test -->
    Route::get('/test/{num}',                                           'ApiController@unitTest');
// <-- for test
// web api -->
    Route::get('/api/sitemap/',                                         'ApiController@ginatonicSitemap');
    Route::get('/api/form/city/{prefectureId}',                         'ApiController@cityList');
    Route::get('/api/form/town/{cityId}',                               'ApiController@townList');
    Route::get('/api/posted/land/price/average/{aId?}/',                'ApiController@ginatonicAverage');
    Route::get('/api/posted/land/price/prefecture/detail/{pId}/',       'ApiController@ginatonicPrefectureDetail');
    Route::get('/api/posted/land/price/city/detail/{pId}/{cId}/',       'ApiController@ginatonicCityDetail');
    Route::get('/api/link/exist/{prefecture?}/{city?}/{townId?}',       'ApiController@linkExists');
    Route::get('/api/link/exist/{prefecture}/{city}/station/{stationId}','ApiController@stationLinkExists');
// <-- web api

    Route::get('/',                                                     'ginatonic\IndexController@index');
    Route::get('/{prefecture}/{city?}/',                                'ginatonic\IndexController@area');
});

