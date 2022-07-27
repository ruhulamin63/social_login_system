<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SocialController;
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

Route::get('/home', [HomeController::class, 'index'])->name('home');

//Social login for facebook
Route::get('login/facebook', [SocialController::class, 'facebook_redirect'])->name('login-facebook');
Route::get('login/facebook/callback', [SocialController::class, 'login_with_facebook'])->name('login-facebook-callback');

//Social login for Google
Route::get('login/google', [SocialController::class, 'google_redirect'])->name('login-google');
Route::get('login/google/callback', [SocialController::class, 'login_with_google'])->name('login-google-callback');

//Social login for gitHub
Route::get('login/github', [SocialController::class, 'github_redirect'])->name('login-github');
Route::get('login/github/callback', [SocialController::class, 'login_with_github'])->name('login-github-callback');
