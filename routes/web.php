<?php

use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('events', EventController::class);

Route::middleware(['can:isOrganizer'])->group(function () {
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
});
    // Trasy dostępne tylko dla roli "organizator"

//Route::get('/events', 'App\Http\Controllers\EventController@store')->name('events.store');


