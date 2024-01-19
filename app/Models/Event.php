<?php

namespace App\Models;


use http\Client\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'place', 'city', 'date', 'time', 'image', 'added_by', 'category_id', 'hall_id'];

    protected $attributes = [
        'place' => 'default',
        'city' => 'default',
        'image' => 'default'
    ];

    public function categories()
    {
        return $this->belongsToMany(EventCategory::class, 'event_event_category', 'event_id', 'category_id');
    }

    public function create()
    {
        $categories = EventCategory::all();
        return view('events.create', compact('categories'));
    }

    protected $dates = ['date'];

    public function ticketTypes()
    {
        return $this->belongsToMany(TicketType::class, 'event_ticket_types', 'event_id', 'ticket_type_id')
            ->withPivot('price');
    }

    public function hall() {
        return $this->belongsTo(Hall::class, 'hall_id');
    }


    public function getDateAttribute($value)
    {
        return Carbon::parse($value);
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function getPlaceAttribute($value)
    {
        return $value ?: 'default';
    }

    public function category()
    {
        return $this->belongsTo(EventCategory::class, 'event_category_id');
    }
    public function index(Request $request)
    {
        $selectedDate = Carbon::parse($request->query('date'))->startOfDay();
        if (!$selectedDate) {
            $selectedDate = Carbon::now()->startOfDay();
        }

        $dates = collect();
        for ($i = 0; $i < 7; $i++) {
            $dates->push($selectedDate->clone()->addDays($i));
        }

        $events = Event::whereDate('date', $selectedDate)->get();

        return view('programme.index', compact('selectedDate', 'dates', 'events'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'place' => 'required',
            'category' => 'required', // Upewnij się, że 'category' jest wymagane
            'date' => 'required',
            'time' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Pozostała logika zapisywania wydarzenia w bazie danych

        return redirect()->route('events.index');
    }

}

