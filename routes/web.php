<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;

use App\Http\Controllers\DashboardController;
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

Route::get('/', [AuthController::class,'showLoginForm'])->name('login');
Route::get('/register', [AuthController::class,'showRegisterForm'])->name('register');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/dashboard',[DashboardController::class,'dashboard'])->name('dashboard');
    Route::get('/refresh-quote',[DashboardController::class,'dashboard'])->name('refreshQuote');
    Route::get('/save-quote-to-favourite/{stringParam}',[DashboardController::class,'saveToFavourite'])->name('saveToFavourite');
    Route::get('/favourites',[DashboardController::class,'getFavourites'])->name('favourites');
    Route::delete('/delete/favourite/{id}',[DashboardController::class,'getFavouriteDelete'])->name('favourite.delete');
    Route::post('/logout',[AuthController::class,'getLogoutUser']);
});
