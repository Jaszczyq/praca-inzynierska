<?php

namespace App\Http\Controllers;


use App\Models\EventCategory;

class EventCategoryController extends Controller
{
    public function index()
    {
        $categories = EventCategory::all();
        return view('categories.index', compact('categories'));
    }
    public function create()
    {
        $categories = EventCategory::all(); //

        return view('events.create', compact('categories'));
    }


}
