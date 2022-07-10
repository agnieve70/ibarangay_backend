<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Help;
use Illuminate\Http\Request;

class HelpController extends Controller
{
    //
    function index(){
        $helps = Help::join('users', 'users.id', 'help.user_id')->get();
        return response()->json([
            "status" => 1,
            "message" => "Fetched Successfully",
            "data" => $helps,
        ], 200);
    }

    function getHelp($id){
        $help = Help::find($id);
        return response()->json([
            "status" => 1,
            "message" => "Fetched Successfully",
            "data" => $help,
        ], 200);
    }

    function create(Request $request){
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
            'status' => 'required',
        ]);

        $help = new Help();
        $help->latitude = $request->latitude;
        $help->longitude = $request->longitude;
        $help->user_id = auth()->user()->id;
        $help->status = $request->status;
        $help->save();

        return response()->json([
            "status" => 1,
            "message" => "Saved Successfully",
            "data" => $help,
        ], 200);
    }
}
