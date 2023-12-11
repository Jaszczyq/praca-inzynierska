<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventCategory;
use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class SeatController extends Controller
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

    public function show($event_id, $seats_ids)
    {
        $event = \App\Event::find($event_id);
        $seats = explode(',', $seats_ids);

        return view('booking.seats', ['event' => $event, 'selectedSeats' => $seats]);
    }
}
