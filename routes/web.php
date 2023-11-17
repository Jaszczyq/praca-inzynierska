<?php

use App\Http\Controllers\EventCategoryController;
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

Route::get('/events/my_events', [EventController::class, 'myEvents'])->name('events.my_events');

Route::middleware(['can:isOrganizer'])->group(function () {
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
});

Route::get('/event/{id}', [EventController::class, 'details'])->name('event.details');

Route::get('/events/search/{name}', [EventController::class, 'search'])->name('event.search');

Route::resource('events', EventController::class);

Route::get('/event/{id}/edit', 'EventsController@edit')->name('event.edit');
Route::get('/event/{id}/delete', 'EventsController@delete')->name('event.delete');
// routes/web.php

//Route::resource('eventcategories', EventCategoryController::class);
//Route::get('eventcategories/filter', EventCategoryController::class, 'filter')->name('eventcategories.filter');





    // Trasy dostępne tylko dla roli "organizator"

//Route::get('/events', 'App\Http\Controllers\EventController@store')->name('events.store');


