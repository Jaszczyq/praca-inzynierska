<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventCategory;
use App\Models\Hall;
use App\Models\Payment;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'title');
        $order = $request->get('order', 'asc');
        $events = Event::orderBy($sort, $order)->get();

        $selectedCategory = $request->input('category');
        $categories = EventCategory::all();

        if ($selectedCategory) {
            $events = Event::where('category_id', $selectedCategory)->whereDate('date', '>=', Carbon::now())->get();
        } else {
            $events = Event::whereDate('date', '>=', Carbon::now())->get();
        }

        $halls = Hall::all();

        return view('events.index', compact('events', 'categories', 'selectedCategory', 'halls'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = EventCategory::all();
        return view('events.create', compact('categories'));
    }


    /**
     * Store a newly created resource in storage.
     */

    public function search(Request $request)
    {
        $title = $request->query('title') ?? '';
        $city = $request->query('city') ?? '';

        $myEvents = $request->query('mySearch');
        $currentDate = now()->toDateString();

        if($myEvents) {
            $events = Event::where('added_by', Auth::user()->id)
                ->where('title', 'like', '%' . $title . '%')
                ->where('city', 'like', '%' . $city . '%')
                ->whereDate('date', '>=', $currentDate)
                ->get();
            return view('events.my_search_results', ['events' => $events]);
        } else {
            $events = Event::where('title', 'like', '%' . $title . '%')
                ->where('city', 'like', '%' . $city . '%')
                ->whereDate('date', '>=', $currentDate)
                ->get();
            return view('events.search_results', ['events' => $events]);
        }
    }

    public function sort(Request $request, string $by, string $order)
    {
        $events = Event::orderBy($by, $order)->whereDate('date', '>=', Carbon::now())->get();

        return view('events.search_results', ['events' => $events]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'image' => 'required|image|max:2048',
            'place' => 'required',
            'city' => 'required',
            'category' => 'required',
            'hall' => 'required',
            'ticket_types.*.id' => 'sometimes|required|exists:ticket_types,id',
            'ticket_types.*.price' => 'sometimes|required|numeric|min:0',
        ]);

        \Log::info($request->all());
        $imagePath = $request->file('image')->store('public/images');
        $imagePath = str_replace('public/', '', $imagePath); // usuwamy 'public/' z ścieżki, aby była dostępna publicznie

        $event = new Event([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'place' => $validatedData['place'],
            'date' => \Carbon\Carbon::parse($validatedData['date'] . ' ' . $validatedData['time'])->format('Y-m-d'),
            'time' => \Carbon\Carbon::parse($validatedData['date'] . ' ' . $validatedData['time'])->format('H:i:s'),
            'image' => asset('storage/' . $imagePath),
            'city' => $validatedData['city'],
            'category_id' => $validatedData['category'],
            'hall_id' => $validatedData['hall'],
            'added_by' => Auth::user()->id,
        ]);

        //dd($validatedData['ticket_types']);

        $event->save();

        $event_id = $event->id;

        foreach ($validatedData['ticket_types'] as $ticketTypeId => $ticketTypeData) {
            DB::table('event_ticket_types')->insert([
                'event_id' => $event_id,
                'ticket_type_id' => $ticketTypeId,
                'price' => $ticketTypeData['price'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }


        $event->categories()->attach($validatedData['category']);

        // Dodawanie cen biletów dla wydarzenia
        /*foreach ($validatedData['ticket_types'] as $ticketTypeData) {
            $event->ticketTypes()->attach($ticketTypeData['id'], [
                'price' => $ticketTypeData['price'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }*/

        return redirect()->route('events.index')->with('success', 'Event added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $event = Event::find($id);

        //check if event exists
        if (!$event) {
            abort(404);
        }

        $event->category = $event->categories->pluck('name');
        $event->ticketTypes = $event->ticketTypes->pluck('name');
        $event->hall = $event->hall->name ?? null;

        //return JASON
        return response()->json($event);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $event = Event::find($id);
        if (!$event) {
            return redirect()->back()->with('error', 'Event not found');
        }

        return view('events.edit', ['event' => $event]);
    }

    public function getEvent($id)
    {
        $event = Event::find($id);
        if (!$event) {
            return response()->json(['error' => 'Event not found'], 404);
        }

        return response()->json($event);
    }

    public function delete(string $id)
    {
        $event = Event::find($id);


        if(!$event) {
            return response()->json(['error' => 'Nie znaleziono wydarzenia'], 404);
        }

        $event->forcedelete();
        return response()->json(['success' => 'Wydarzenie zostało usunięte'], 200);
    }

    public function filter(Request $request) {
        $categories = $request->input('categories');
        $myEvents = $request->input('myEvents');

        if($myEvents) {
            if (empty($categories)) {
                $events = Event::where('added_by', Auth::user()->id)->get();
            } else {
                $events = Event::where('added_by', Auth::user()->id)->whereIn('category_id', $categories)->get();
            }

            return view('events.my_search_results', ['events' => $events]);
        }
        else {
            if (empty($categories)) {
                $events = Event::get();
            } else {
                $events = Event::whereIn('category_id', $categories)->get();
            }

            return view('events.search_results', ['events' => $events]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $event = Event::find($id);
        if (!$event) {
            return redirect()->back()->with('error', 'Event not found');
        }

        $data = $request->all();
        //dd($data);
        //$result = $event->update($data);

        $event->title = $data['title'];
        $event->description = $data['description'];
        $event->city = $data['city'];
        $event->place = $data['place'];
        $event->date = $data['date'];
        $event->time = $data['time'];
        $event->hall_id = $data['hall'];

        if(isset($data['image'])) {
            $imagePath = $request->file('image')->store('public/images');
            $imagePath = str_replace('public/', '', $imagePath); // usuwamy public z ścieżki, aby była ona dostępna publicznie
            $event->image = asset('storage/' . $imagePath);
        }

        $event->save();
        $event->restore();

        return redirect()->route('events.index')->with('success', 'Event updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function details(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'image' => 'required|image|max:2048',
            'place' => 'required',
            'city' => 'required',
        ]);

        $imagePath = $request->file('image')->store('public/images');
        $imagePath = str_replace('public/', '', $imagePath); // usuwamy public z ścieżki, aby była ona dostępna publicznie

        $event = new Event();

        $event->title = $validatedData['title'];
        $event->description = $validatedData['description'];
        $event->place = $validatedData['place'];
        $event->date = \Carbon\Carbon::parse($validatedData['date'] . ' ' . $validatedData['time'])->format('Y-m-d');
        $event->time = \Carbon\Carbon::parse($validatedData['date'] . ' ' . $validatedData['time'])->format('H:i:s');
        $event->image = asset('storage/' . $imagePath);
        $event->city = $validatedData['city'];
        $event->hall_id = $request->input('hall');

        $event->save();


        return redirect()->route('events.index');
    }


    public function myEvents(Request $request)
    {
        if (!Auth::check() || !Auth::user()->isOrganizer()) {
            abort(403, 'Brak uprawnień');
        }

        $selectedCategory = $request->input('category');
        $categories = EventCategory::all();
        $userId = Auth::user()->id;

        $halls = Hall::all();

        try {
            $currentEventsQuery = Event::where('added_by', $userId)->whereDate('date', '>=', Carbon::now());
            $archivedEventsQuery = Event::where('added_by', $userId)->whereDate('date', '<', Carbon::now());

            if ($selectedCategory) {
                $currentEventsQuery = $currentEventsQuery->where('category_id', $selectedCategory);
                $archivedEventsQuery = $archivedEventsQuery->where('category_id', $selectedCategory);
            }

            $currentEvents = $currentEventsQuery->orderBy('date', 'asc')->get();
            $archivedEvents = $archivedEventsQuery->orderBy('date', 'desc')->get();

        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'An error occurred.');
        }

        return view('events.my_events', compact('currentEvents', 'archivedEvents', 'categories', 'selectedCategory', 'halls'));
    }

    public function tickets()
    {
        if (!Auth::check()) {
            abort(403, 'Brak uprawnień');
        }

        $tickets = Ticket::where('user_id', Auth::user()->id)->get();
        $categories = EventCategory::all();

        return view('events.tickets', compact('tickets', 'categories'));
    }

    public function sortTickets($by, $order)
    {
        /*$tickets = Ticket::with(['event' => function ($query) use ($by, $order) {
            $query->orderBy($by, $order);
        }])
            ->where('user_id', Auth::user()->id)
            ->get();*/
        $tickets = Ticket::join('events', 'events.id', '=', 'tickets.event_id')
            ->where('user_id', Auth::user()->id)
            ->orderBy("events.".$by, $order)
            ->get();

        $categories = EventCategory::all();

        return view('events.tickets_search_results', compact('tickets', 'categories'));
    }

    public function refundTickets($ticket_id)
    {
        $ticket = Ticket::find($ticket_id);
        return view('events.refund_ticket', compact('ticket'));
    }

    public function sendDataForRefund(Request $request)
    {
        $ticket = Ticket::find($request->get('ticket_id'));

        $price = $request->get('ticketPrice');
        $email = $request->get('email');

        // check if difference betweem price and ticket price is equal to 0
        $price = floatval($price);
        $ticketPrice = floatval($ticket->price);

        if ($price == $ticketPrice && $email == $ticket->user->email) {
            // check if ticket is not already in refunds table
            if (DB::table('refunds')->where('ticket_id', $ticket->id)->exists()) {
                return response()->json(['success' => 'Success']);
            }
            DB::table('refunds')->insert([
                'ticket_id' => $ticket->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        return response()->json(['success' => 'Success']);
    }

    public function showInfo()
    {
        return view('events.refund_success');
    }
}
