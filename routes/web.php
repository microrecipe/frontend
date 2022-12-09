<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SignInController;
use App\Http\Controllers\SignUpController;
use Illuminate\Http\Request;
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

Route::get('/', function (Request $request) {
    $isLoggedIn = $request->session()->get('access_token', null);

    return view('home', ['isLoggedIn' => $isLoggedIn]);
})->name('home');

Route::prefix('/user')->group(function () {

    Route::get(
        '/sign-in',
        function () {
            return view('auth/sign_in', ['loginError' => false]);
        }
    )->name('auth.view.signin');

    Route::post('/sign-in', [AuthController::class, 'signIn'])->name('auth.signin');
    Route::get('/sign-out', [AuthController::class, 'signOut'])->name(('auth.signout'));
});

// Route::get('/sign-up', [SignUpController::class, 'index']);
