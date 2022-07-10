<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DocumentCategory;
use Illuminate\Http\Request;

class DocumentCategoryController extends Controller
{
    //
    function index(){
        $categories = DocumentCategory::get();
        return response()->json([
            "status" => 1,
            "message" => "Fetched Successfully",
            "data" => $categories,
        ], 200);
    }
    
    function create(Request $request){

        $request->validate([
            'category' => 'required',
        ]);

        $category = new DocumentCategory();
        $category->category = $request->category;
        $category->save();

        return response()->json([
            "status" => 1,
            "message" => "Saved Successfully",
            "data" => $category,
        ], 200);
    }
}
