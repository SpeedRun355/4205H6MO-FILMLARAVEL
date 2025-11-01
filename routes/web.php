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
Route::resource('filmUser', FilmUserController::class);
Route::resource('film', FilmController::class)->only(['index', 'show']);

Route::get('lang/{locale}', 
[App\Http\Controllers\LocalizationController::class, 'index']);

Auth::routes();
Auth::routes(['verify' => true]);

Route::get('email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (Illuminate\Foundation\Auth\EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Illuminate\Http\Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', function () {
        return 'User Profile';
    });
    
    Route::get('/apropos', function () {
        return view('films.apropos');
    })->name('apropos');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return 'Admin Dashboard';
    });
    Route::resource('film', FilmController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', function () {
        return 'User Profile';
    });
});
