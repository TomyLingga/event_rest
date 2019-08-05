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
Route::get('login','API\UserController@login');
Route::post('register','API\UserController@register');
Route::get('ticket/{id}','TicketController@index');
Route::get('event/{id}','EventController@index1');

Route::group(['middleware' => 'auth:api'], function(){
    Route::post('details', 'API\UserController@details');
    });

//tambah route buat user
