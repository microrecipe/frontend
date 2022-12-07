<?php

use App\Http\Controllers\SignInController;
use App\Http\Controllers\SignUpController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

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

URL::forceRootUrl(config('app.url'));

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/sign-in', [SignInController::class, 'index']);
Route::post('/sign-in', [SignInController::class, 'signIn'])->name('auth.signin');

Route::get('/sign-up', [SignUpController::class, 'index']);
