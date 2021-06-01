<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\TwitterController;
use Illuminate\Support\Facades\Route;

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

Route::get('/home', function () {
    return view('welcome');
});

Route::get('login',[LoginController::class, 'login']);
Route::get('oauth-back',[LoginController::class, 'oauthBack'])->name("twitter.callback");

Route::get('twitter/create',[TwitterController::class, 'createTwitter']);
Route::get('twitter/timeline',[TwitterController::class, 'timeline']);
Route::get('twitter/friends',[TwitterController::class, 'friends']);
