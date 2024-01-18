<?php

use App\Http\Controllers\DetailsController;
use App\Http\Controllers\EventCategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HallsController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SeatController;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;


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


Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Auth::routes();

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/events/details', [DetailsController::class, 'show']);

Route::get('/events/my_events', [EventController::class, 'myEvents'])->name('events.my_events');

Route::middleware(['can:isOrganizer'])->group(function () {
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
});

Route::get('/event/{id}', [EventController::class, 'details'])->name('event.details');

Route::get('/events/search', [EventController::class, 'search'])->name('event.search');

Route::get('/events/filter', [EventController::class, 'filter'])->name('events.filter');

Route::get('/events/sort/{by}/{order}', [EventController::class, 'sort'])->name('event.sort');

// Route::get('events.index', [EventController::class, 'index']);

Route::resource('events', EventController::class);

Route::get('/event/{id}/edit', [EventController::class, 'edit'])->name('event.edit');
Route::delete('/event/{id}/delete', [EventController::class, 'delete'])->name('event.delete');
Route::post('/event/{id}/update', [EventController::class, 'update'])->name('event.update');

Route::get('/seats/{id}', function ($id) {
    $event = Event::find($id);
    return view('booking.seats', ['event' => $event]);
})->name('seats');

Route::get('/payment/{id}', function ($id) {
    $event = Event::find($id);
    return view('booking.payment', ['event' => $event]);
})->name('payment');

Route::post('/events/{event_id}/details', [DetailsController::class, 'show']);
Route::get('/seats/{event_id}/{seats}', [SeatController::class, 'show']);

Route::get('/purchase-summary/{event_id}/{seats}', [PurchaseController::class, 'showSummary']);
Route::get('/reservation-summary/{event_id}/{seats}', [ReservationController::class, 'showSummary']);

Route::get('/seats_creator', function () {
    return view('booking.seats_creator');
})->name('seats_creator');

Route::get('/halls/{id}', [HallsController::class, 'getHall'])->name('booking.get_hall');
Route::post('/halls', [HallsController::class, 'saveHall'])->name('booking.save_hall');

Route::post('/seats_creator', [EventController::class, 'saveHall'])->name('seats_creator.save');

Route::post('/payment/confirm', [PurchaseController::class, 'confirmPayment'])->name('payment.confirm');
Route::get('/payment/{transaction_id}/gateway', [PurchaseController::class, 'payment'])->name('payment.transaction');
Route::get('/payment/{transaction_id}/success', [PurchaseController::class, 'successPayment'])->name('payment.success');
Route::get('/payment/{transaction_id}/fail', [PurchaseController::class, 'failPayment'])->name('payment.fail');
Route::get('/payment/{transaction_id}/pending', [PurchaseController::class, 'pendingPayment'])->name('payment.pending');
Route::get('/payment/{transaction_id}/no_payment', [PurchaseController::class, 'noPayment'])->name('payment.no_payment');

Route::get('/debug_mail', [ForgotPasswordController::class, 'debugMail'])->name('mail.debug');
