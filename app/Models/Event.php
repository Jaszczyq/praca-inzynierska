<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'date', 'time', 'image'];

    protected $attributes = [
        'place' => 'default'
    ];

    protected $dates = ['date'];

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

}

