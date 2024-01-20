<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventCategory;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Ticket;
use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'title');
        $order = $request->get('order', 'asc');
        $events = Event::orderBy($sort, $order)->get();
    }

    public function showSummary($event_id, $seats_ids)
    {
        $event = Event::find($event_id);

        $seats = explode(',', $seats_ids);

        return view('booking.purchase_summary', ['event' => $event, 'selectedSeats' => $seats]);
    }

    public function confirmPayment(Request $request)
    {
        $payment_method = DB::table('payments_methods')->where('name', $request->get('paymentMethod'))->first();
        $payment = new Payment();

        $payment->user_id = Auth::user()->id;
        $payment->method_id = $payment_method->id;
        $payment->currency_id = 1;
        $payment->status = 7;
        $payment->amount = $request->get('price');
        $payment->item_name = 'Testowa płatność';
        $payment->transaction_id = UUID::uuid4()->toString();
        $payment->details = $request->get('selectedSeats');

        $payment->save();

        $selectedSeats = json_decode($request->get('selectedSeats'));

        foreach ($selectedSeats as $data) {
            $reservation = new Reservation();

            $reservation->event_id = $request->get('eventId');
            $reservation->seat = $data->seat;

            $reservation->save();
        }

        // return json with url to redirect
        return response()->json(['url' => route('payment.transaction', ['transaction_id' => $payment->transaction_id])]);
    }

    public function payment($transaction_id) {
        $payment = Payment::where('transaction_id', $transaction_id)->first();
        return view('booking.payment_gateway', ['payment' => $payment]);
    }

    public function successPayment($transaction_id) {
        $payment = Payment::where('transaction_id', $transaction_id)->first();
        $payment->status = 3;
        $payment->save();

        $selectedSeats = json_decode($payment->details);

        foreach ($selectedSeats as $data) {
            $ticket = new Ticket();

            $ticket->event_id = DB::table('reservations')->where('seat', $data->seat)->first()->event_id;
            $ticket->ticket_type_id = $data->type;
            $ticket->seat = $data->seat;
            $ticket->user_id = Auth::user()->id;
            $ticket->price = explode(' ', $data->price)[0];

            $ticket->save();
        }

        // tu można zrobić wysyłkę maila
        return view('booking.payment_status', ['payment' => $payment]);
    }

    public function failPayment($transaction_id) {
        $payment = Payment::where('transaction_id', $transaction_id)->first();
        $payment->status = 6;
        $payment->save();
        // tu można zrobić wysyłność maila o błędzie
        return view('booking.payment_status', ['payment' => $payment]);
    }

    public function pendingPayment($transaction_id) {
        $payment = Payment::where('transaction_id', $transaction_id)->first();
        $payment->status = 1;
        $payment->save();
        return view('booking.payment_status', ['payment' => $payment]);
    }

    public function noPayment($transaction_id) {
        $payment = Payment::where('transaction_id', $transaction_id)->first();
        $payment->status = 4;
        $payment->save();
        return view('booking.payment_status', ['payment' => $payment]);
    }
}
