<?php

use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OfferController;
use App\Http\Middleware\CheckRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JwtMiddleware;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


// Route::get('index',[TestController::class,'index']);

// Route::post('register',[AuthController::class,'register']);
// Route::post('login',[AuthController::class,'login']);
// Route::post('logout',[AuthController::class,'logout']);

// Route::get('getAlluser',[AuthController::class,'getAlluser']);
// Route::get('/{id}',[AuthController::class,'show']);
// Route::put('/{id}',[AuthController::class,'updateUser']);
// Route::delete('/{id}',[AuthController::class,'deleteUser']);


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware([JwtMiddleware::class])->group(function () {

    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'getUser']);
    Route::put('user', [AuthController::class, 'updateUser']);
    Route::middleware([CheckRole::class.':admin'])->group(function(){
    
        Route::apiResource('offer',OfferController::class);
    
    });
  
  
});