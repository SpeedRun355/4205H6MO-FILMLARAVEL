<?php

use App\Http\Controllers\FilmController;
use App\Http\Controllers\FilmUserController;
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
Route::get('/apropos', function () {
    return view('apropos');
}); 

Route:: get ('/', [FilmController::class, 'index']);
//création des routes avec resources
Route::resources([
                 'film'=> FilmController::class,
                 'filmUser'=> FilmUserController::class,
                ]);

