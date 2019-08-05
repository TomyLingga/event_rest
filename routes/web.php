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

Route::get('/home', 'HomeController@index')->name('home');


// $router->get('event/{id}','EventController@index1'); // untuk me list 1 event
// $router->get('event/update/{id}','EventController@updateEvent'); //for updating event
// $router->post('event/delete/{id}','EventController@deleteEvent');  // for deleting event
// $router->post('ticket/{id}', 'TicketController@joinEvent'); // untuk generate QR
