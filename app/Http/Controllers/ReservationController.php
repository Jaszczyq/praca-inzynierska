<?php

namespace App\Http\Controllers;

use App\Mail\TicketMail;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Ticket;
use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ReservationController extends Controller
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

        return view('booking.reservation_summary', ['event' => $event, 'selectedSeats' => $seats]);
    }

}
