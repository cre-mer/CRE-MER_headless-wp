<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Libraries\RequestLibrary;

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

/*
 * We create a dedicated WordPress authentication controller to get access tokens
 */
Route::group(['middleware' => 'auth'], function () {
    Route::get('get-token', 'WP\AuthController@getToken');
    Route::get('process-token', 'WP\AuthController@processToken');
});


/*
 * WP Admin
 */
Route::get('/wp-admin/{any?}', function () {
    $url = 'http://' . env('WP_API_BASE_URL');
    $url .= $_SERVER['REQUEST_URI'];

    return Redirect::to($url);
})->where('any', '.*');

/*
 * Show Image
 */
Route::get('/wp-content/uploads/{year}/{month}/{filename}', 'WP\UploadsController@showWpImage');

/*
 * Show post based on slug
 */
Route::get('/{slug}', function ($slug) {
    $requestLibrary = new RequestLibrary();
    $post = $requestLibrary->getPost($slug) ?? abort(404);


    if ($post[0] == 'posts') {
        return view('layouts.post', ['post' => $post[1][0]]); // [0] because we're using custom permalinks example post slug
    } elseif ($post[0] == 'pages') {
        return view('layouts.page', ['post' => $post[1][0]]); // [0] because we're using custom permalinks example post slug
    }
});
