<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    //
    function getDocumentsByUser(){
        $documents = Document::select('document.id','firstname', 'lastname', 'name', 'email', 
        'document_category.category', 'title', 'status', 'document.created_at', 'document.updated_at')
        ->join('document_category', 
        'document_category.id', 'document.category_id')
        ->join('users', 'users.id', 'document.user_id')
        ->orderBy('status', 'desc')
        ->where('user_id', auth()->user()->id)
        ->get();
        return response()->json([
            "status" => 1,
            "message" => "Fetched Successfully",
            "data" => $documents,
        ], 200);
    }

    function index(){
        $documents = Document::select('document.id', 'firstname', 'lastname','name', 'email', 
        'document_category.category', 'title', 'status', 'document.created_at', 'document.updated_at')
        ->join('document_category', 
        'document_category.id', 'document.category_id')
        ->join('users', 'users.id', 'document.user_id')
        ->orderBy('status', 'desc')
        ->get();
        return response()->json([
            "status" => 1,
            "message" => "Fetched Successfully",
            "data" => $documents,
        ], 200);
    }

    function create(Request $request){
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'status' => 'required',
        ]);

        if(Document::where('user_id', auth()->user()->id)
        ->where('status', 'on process')->first()){
            return response()->json([
                "status" => 0,
                "message" => "1 Request at a time",
            ], 401);
        }

        $document = new Document();
        $document->title = $request->title;
        $document->category_id = $request->category_id;
        $document->status = $request->status;
        $document->user_id = auth()->user()->id;
        $document->save();

        return response()->json([
            "status" => 1,
            "message" => "Saved Successfully",
            "data" => $document,
        ], 200);
    }

    function update(Request $request){
        $document  = Document::find($request->id);

        if(!$document){
            return response()->json([
                "status" => 0,  
                "message" => "Request Document not found",
            ], 200);
        }

        $document->title = !empty($request->title) ? $request->title : $document->title;
        $document->category_id = !empty($request->category_id) ? $request->category_id : $document->category_id;
        $document->status = !empty($request->status) ? $request->status : $document->status;
        $document->save();

        return response()->json([
            "status" => 1,
            "message" => "Updated Successfully",
            "data" => $document,
        ], 200);
    }

}
