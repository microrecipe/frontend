<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RecipeController;
use App\Http\Middleware\SessionAuth;
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

Route::controller(HomeController::class)->prefix('/')->group(function () {
    Route::get('', 'index')->name('home');
});

Route::controller(AuthController::class)->prefix('/user')->group(function () {
    Route::get('/sign-in', 'index')->name('auth.view.signin');

    Route::post('/sign-in', 'signIn')->name('auth.signin');
    Route::get('/sign-out', 'signOut')->name(('auth.signout'));
});

Route::controller(OrderController::class)->prefix('/user/orders')->group(function () {
    Route::get('', 'index')->name('orders.view.orders');
    Route::get('/cart', 'listItemsInCart')->name('orders.view.cart');
})->middleware(SessionAuth::class);

Route::controller(RecipeController::class)->prefix('/main/recipes')->group(function () {
    Route::get('', 'index')->name('recipes.view.recipes');
    Route::get('/add', 'viewAddRecipe')->name('recipes.view.add_recipe')->middleware(SessionAuth::class);

    Route::post('/add', 'addRecipe')->name('recipes.add_recipe')->middleware(SessionAuth::class);
    Route::post('/add-to-cart/{recipeId}', 'addIngredientsToCart')->name('recipes.add_to_cart')->middleware(SessionAuth::class);
});

// Route::get('/user/orders', [OrderController::class, 'index'])->middleware(SessionAuth::class)->name('orders.view.orders');

// Route::get('/sign-up', [SignUpController::class, 'index']);
