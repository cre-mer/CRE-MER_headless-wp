<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

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

/**
 * We create a dedicated WordPress authentication controller to get access tokens
 */
Route::group(['middleware' => 'auth'], function () {
    Route::get('get-token', 'WP\AuthController@getToken');
    Route::get('process-token', 'WP\AuthController@processToken');
});
