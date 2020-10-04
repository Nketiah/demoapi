<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

   
Route::prefix("auth")->group(function(){
    Route::post("login", [AuthController::class, "login"]);
    Route::post("register", [AuthController::class, "register"]);
});

Route::group(["middleware" => "auth:sanctum"], function(){
    Route::get("user", [AuthController::class, "index"]);
    Route::post("logout", [AuthController::class, "logout"]);
});

