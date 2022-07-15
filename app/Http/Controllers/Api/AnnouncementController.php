<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    //
    public function index(){
        $announcements = Announcement::get();
        return response()->json([
            "status" => 1,
            "message" => "Fetched Successfully",
            "data" => $announcements,
        ], 200);
    }

    public function create(Request $request){
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $announcement = new Announcement();
        $announcement->title = $request->title;
        $announcement->content = $request->content;
        $announcement->save();

        return response()->json([
            "status" => 1,
            "message" => "Saved Successfully",
            "data" => $announcement,
        ], 200);
    }
}
