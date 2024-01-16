<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use Illuminate\Http\Request;

class HallsController extends Controller
{
    public function getHall($id) {
        $hall = Hall::find($id);

        return response()->json([
            'hall' => $hall
        ]);
    }

    public function saveHall(Request $request) {
        if(!$request->has('id'))
            $hall = new Hall();
        else
            $hall = Hall::find($request->id);

        $hall->name = $request->name;
        $hall->json_template = $request->json_template;

        $hall->save();

        return response()->json([
            'success' => true
        ]);
    }
}
