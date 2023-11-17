<?php

namespace App\Http\Controllers;


use App\Models\EventCategory;
use Illuminate\Http\Request;

class EventCategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = EventCategory::all();
        $query = EventCategory::query();

        if ($request->has('category') && $request->filled('category')) {
            $query->whereHas('events', function ($q) use ($request) {
                $q->whereIn('id', $request->category);
            });
        }

        $filteredCategories = $query->get();

        return view('categories.index', compact('filteredCategories', 'categories'));
    }

    public function create()
    {
        $categories = EventCategory::all(); //

        return view('events.create', compact('categories'));
    }



}
