<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HelpCategory;
use Illuminate\Http\Request;

class HelpCategoryController extends Controller
{
    //
    function index(){
        $categories = HelpCategory::get();
        return response()->json([
            "status" => 1,
            "message" => "Fetched Successfully",
            "data" => $categories,
        ], 200);
    }

    function create(Request $request){

        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $category = new HelpCategory();
        $category->title = $request->title;
        $category->content = $request->content;
        $category->save();
        return response()->json([
            "status" => 1,
            "message" => "Saved Successfully",
            "data" => $category,
        ], 200);
    }
}
