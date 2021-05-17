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

Route::post('/login', 'UserController@login');
Route::post('/register', 'UserController@register');
Route::get('/airport', 'AirportController@search');

Route::get('/flight', 'FlightController@search');
Route::post('/booking', 'BookingController@store');
Route::get('/booking/{code}', 'BookingController@show');
Route::patch('booking/{code}/seat', 'BookingController@takePlace');
Route::get('/booking/{code}/seat', 'BookingController@getSeats');

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('/user/booking', 'UserController@getBookings');
    Route::get('/user', 'UserController@show');
    //наши маршруты
});