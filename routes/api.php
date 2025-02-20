<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/getCommonData', 'ApiController@getCommonData');
Route::get('/getContactData', 'ApiController@getContactData');

Route::get('/getHomeData', 'ApiController@getHomeData');
Route::get('/singleTemplate/{page?}', 'ApiController@singleTemplate');
Route::get('/getTerm/{termSlug?}', 'ApiController@getTerm');
Route::get('/getPosts', 'ApiController@getPosts');
Route::get('/getTerms', 'ApiController@getTerms');

Route::post('/contactUsData','ApiController@saveContactFormData');
Route::post('/subscribeUs','ApiController@subscribeUs');
Route::post('/applyNow','ApiController@saveApplyNowFormData');

