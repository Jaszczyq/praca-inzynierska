<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $selectedCategory = $request->input('category');
        $categories = EventCategory::all();

        if ($selectedCategory) {
            $events = Event::where('category_id', $selectedCategory)->whereDate('date', '>=', Carbon::now())->get();
        } else {
            $events = Event::whereDate('date', '>=', Carbon::now())->get();
        }

        return view('events.index', compact('events', 'categories', 'selectedCategory'));
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

    public function search(Request $request, string $id) {
        $query = $id;

        if($query === '' || $query === 'all') {
            $events = Event::whereDate('date', '>=', Carbon::now())->get();
        }
        else {
            $events = Event::where('title', 'like', '%' . $query . '%')->whereDate('date', '>=', Carbon::now())->get();
        }

        return view('events.search_results', ['events' => $events]);
    }

    /*public function filterCategory(Request $request, string categoryName) {
        $query = $categoryName;

        return view('events.search_results', ['events' => $events]);
    }*/
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
        $event->city= $validatedData['city'];

        $event->save();


        return redirect()->route('events.index');
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

        //return JASON
        return response()->json($event);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
    {
        return view('events.edit', ['event' => $event]);
    }

    public function delete(String $id)
    {
        return redirect()->route('events.my_events')->with('success', 'Wydarzenie zostało usunięte');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
        $event->city= $validatedData['city'];

        $event->save();


        return redirect()->route('events.index');
    }

    public function myEvents(Request $request) {
        $selectedCategory = $request->input('category');
        $categories = EventCategory::all();

        try {
            if ($selectedCategory) {
                $events = Event::where('category_id', $selectedCategory)->whereDate('date', '>=', Carbon::now())->get()->where('added_by', Auth::user()->id)->get();
            } else {
                $events = Event::whereDate('date', '>=', Carbon::now())->where('added_by', Auth::user()->id)->get();
            }
        } catch (\Exception $e) {
            redirect()->route('home');
        }

        return view('events.index', compact('events', 'categories', 'selectedCategory'));
    }

    /*public function myEvents(Request $request)
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
        $imagePath = str_replace('public/', '', $imagePath);

        $event = new Event();

        $event->title = $validatedData['title'];
        $event->description = $validatedData['description'];
        $event->place = $validatedData['place'];
        $event->date = \Carbon\Carbon::parse($validatedData['date'] . ' ' . $validatedData['time'])->format('Y-m-d');
        $event->time = \Carbon\Carbon::parse($validatedData['date'] . ' ' . $validatedData['time'])->format('H:i:s');
        $event->image = asset('storage/' . $imagePath);
        $event->city= $validatedData['city'];
        $event->added_by = Auth::user()->getAuthIdentifier();

        $event->save();

        //return redirect()->route('events.my_events');
    }*/
}
