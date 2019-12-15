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

Route::get('event','EventController@index');                                    // url untuk me list semua event
Route::post('event/tambah','EventController@createEvent');                      // url untuk tambah event
Route::post('ticket/join','TicketController@create');                           // url untuk buat tiket
Route::post('register','API\UserController@register');                          // url untuk daftar
Route::get('event/mengikuti/{userId}','EventController@eventByUidMengikuti');   // url untuk me list event2 yang sudah di join oleh user
Route::get('search/{cari}','SearchController@search');                          // url untuk search
Route::get('ticket/{idevent}','TicketController@index');                        // url untuk list2 user yang join suatu event
Route::get('ticket/scan/{qrCode}','TicketController@scan');                     // url untuk scan
Route::get('event/user/{uid}','EventController@index2');                        // url untuk me List My Event
Route::get('ticket/cetak_pdf/{idevent}', 'TicketController@cetak_pdf');
Route::get('ticket/{eid}/{uidMengikuti}','TicketController@indexById');         // url untuk mengambil tiket seorang user dari suatu event
Route::get('event/{id}/{uid}','EventController@index1');                        // url untuk Detail Event
Route::get('login/{email}/{password}','API\UserController@login');              // url untuk login

Route::group(['middleware' => 'auth:api'], function(){
    Route::post('details', 'API\UserController@details');
    });

//tambah route buat user
