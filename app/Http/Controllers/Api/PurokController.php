<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Purok;
use Illuminate\Http\Request;

class PurokController extends Controller
{
    //
    public function index(){
        $puroks = Purok::get();
        return response()->json([
            "status" => 1,
            "message" => "Fetched Successfully",
            "data" => $puroks,
        ], 200);
    }

    public function create(Request $request){
        $request->validate([
            'purok' => 'required',
        ]);

        $purok = new Purok();
        $purok->purok = $request->purok;
        $purok->save();

        return response()->json([
            "status" => 1,
            "message" => "Saved Successfully",
            "data" => $purok,
        ], 200);
    }
}
