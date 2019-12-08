<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('event','EventController@index'); // untuk me list semua event
Route::post('event/tambah','EventController@createEvent');
Route::post('ticket/join','TicketController@create');
//Route::get('login','API\UserController@login');
Route::post('register','API\UserController@register');
Route::get('event/mengikuti/{userId}','EventController@eventByUidMengikuti');
Route::get('search/{cari}','SearchController@search');
Route::get('ticket/{idevent}','TicketController@index');
Route::get('ticket/scan/{qrCode}','TicketController@scan');
Route::get('ticket/{eid}/{uidMengikuti}','TicketController@indexById');
Route::get('event/user/{uid}','EventController@index2');
Route::get('event/{id}/{uid}','EventController@index1');
Route::get('login/{email}/{password}','API\UserController@login');


Route::group(['middleware' => 'auth:api'], function(){
    Route::post('details', 'API\UserController@details');
    });

//tambah route buat user
