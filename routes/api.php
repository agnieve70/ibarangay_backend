<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\DocumentCategoryController;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\HelpCategoryController;
use App\Http\Controllers\Api\HelpController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post("register", [ RegisterController::class, "index"]);
Route::post("login", [ LoginController::class, "index"]);

Route::group(["middleware" => ["auth:sanctum"]], function () {
    Route::get("document/categories", [ DocumentCategoryController::class, "index"]);
    Route::post("document/category/create", [ DocumentCategoryController::class, "create"]);
    Route::get("documents", [ DocumentController::class, "index"]);
    Route::post("document/create", [ DocumentController::class, "create"]);
    Route::post("document/update", [ DocumentController::class, "update"]);

    Route::get("help/category", [ HelpCategoryController::class, "index"]);
    Route::post("help/category/create", [ HelpCategoryController::class, "create"]);
    Route::post("help/category/update", [ HelpCategoryController::class, "update"]);

    Route::get("help", [ HelpController::class, "index"]);
    Route::get("help/{id}", [ HelpController::class, "getHelp"]);
    Route::post("help/create", [ HelpController::class, "create"]);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
