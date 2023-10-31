<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_event_category', 'category_id', 'event_id');
    }

    public function create()
    {
        $categories = EventCategory::all();
        return view('events.create', compact('categories'));
    }

}
