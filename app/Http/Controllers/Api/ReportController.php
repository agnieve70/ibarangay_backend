<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Help;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    //
    function index(){
        $reports = Report::select('report.id','report.title as report_title','content','category','report.status',
        'representative_id', 'help_category.title as category', 'report.created_at', 'report.updated_at',
        DB::raw('(SELECT name from users WHERE users.id = help.user_id) as `helped_user`'))
        ->join('help', 'help.id', 'report.help_id')
        ->join('help_category', 'help_category.id', 'report.category')
        ->get();

        return response()->json([
            "status" => 1,
            "message" => "Fetched Successfully",
            "data" => $reports,
        ], 200);
    }

    function create(Request $request){
        $request->validate([
            'help_id' => 'required',
            'representative_id' => 'required',
            'title' => 'required',
            'content' => 'required',
            'category' => 'required',
        ]);

        $report = new Report();
        $report->help_id = $request->help_id;
        $report->representative_id = $request->representative_id;
        $report->title = $request->title;
        $report->content = $request->content;
        $report->category = $request->category;
        $report->status = "done";
        $report->save();

        return response()->json([
            "status" => 1,
            "message" => "Saved Successfully",
            "data" => $report,
        ], 200);
    }
}
