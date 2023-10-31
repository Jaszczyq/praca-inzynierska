<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $selectedDate = Carbon::parse($request->input('date', Carbon::now()->toDateString()));
        $dates = collect();
        for ($i = 0; $i < 7; $i++) {
            $dates->push($selectedDate->clone()->addDays($i));
        }

        $events = Event::whereDate('date', $selectedDate)->get();

        return view('programme.index', compact('selectedDate', 'dates', 'events'));
        $categories = EventCategory::all();
        $selectedCategory = $request->input('category'); // Pobierz wybraną kategorię z formularza

        if ($selectedCategory) {
            $events = Event::where('event_category_id', $selectedCategory)->get();
        } else {
            $events = Event::all(); // Pobierz wszystkie wydarzenia, jeśli nie wybrano kategorii
        }

        return view('programme.index', compact('events', 'categories', 'selectedCategory'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function search(Request $request) {
        $query = $request->get('query');
        $events = Event::where('name', 'like', '%' . $query . '%')->get();
        return view('search_results', ['events' => $events]);
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

        $event->save();


        return redirect()->route('events.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
}
