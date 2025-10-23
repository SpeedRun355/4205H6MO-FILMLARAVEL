<?php

use App\Http\Controllers\FilmController;
use App\Http\Controllers\FilmUserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LocalizationController;
use App\Models\FilmUser;

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route:: get ('/', [FilmController::class, 'index']);
Route::post('/autocomplete', [FilmUserController::class,'autocomplete'])->name('autocomplete');
//création des routes avec resources
Route::resources([
                 'film'=> FilmController::class,
                 'filmUser'=> FilmUserController::class,
                ]);

Route::get('lang/{locale}', 
[App\Http\Controllers\LocalizationController::class, 'index']);

Auth::routes();
Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', function () {
        return 'User Profile';
    });
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return 'Admin Dashboard';
    });
    Route::get('/apropos', function () {
        return view('films.apropos');
    })->name('apropos');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', function () {
        return 'User Profile';
    });
});
