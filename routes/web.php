<?php

use App\Http\Controllers\FilmController;
use App\Http\Controllers\FilmUserController;
use Illuminate\Support\Facades\Route;
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
Route::get('/apropos', function () {
    return view('apropos');
}); 

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
