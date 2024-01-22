<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventCategory;
use App\Models\Payment;
use App\Models\Refund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

class RefundController extends Controller
{
    public function refundList() {
        $organiserId = Auth::user()->id;
        $organiserEvents = Event::where('added_by', $organiserId)->get();

        $refundedTickets = Refund::whereIn('ticket_id', function ($query) use ($organiserEvents) {
            $query->select('id')
                ->from('tickets')
                ->whereIn('event_id', $organiserEvents->pluck('id'));
        })->get();

        $categories = EventCategory::all();

        return view('refunds.list', compact('refundedTickets', 'categories'));
    }

    public function refundTickets(Request $request) {
        $accepted = $request->input('accepted');
        $refund_id = $request->input('refund_id');

        $refund = Refund::find($refund_id)->with('ticket')->first();
        $ticket = $refund->ticket;

        $refund->forceDelete();

        if($accepted == 'true') {
            $refundPayment = new Payment();
            $refundPayment->user_id = $ticket->user_id;
            $refundPayment->amount = -$ticket->price;
            $refundPayment->currency_id = 1;
            $refundPayment->method_id = 13;
            $refundPayment->status = 5;
            $refundPayment->item_name = 'Zwrot za bilet';
            $refundPayment->transaction_id = UUID::uuid4()->toString();

            $refundPayment->save();

            $ticket->forceDelete();
        }

        return response()->json(['success' => 'Zapisano'], 200);
    }
}
