<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventCategory;
use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

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

        /*
        $ticket_ids = explode(',', $ticket_ids);
        $selectedTickets = TicketType::whereIn('id', $ticket_ids)->get();
        */
        $seats = explode(',', $seats_ids);

        return view('booking.purchase_summary', ['event' => $event, 'selectedSeats' => $seats]);
    }
}
