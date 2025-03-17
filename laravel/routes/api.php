<?php

use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('index',[TestController::class,'index']);

Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::get('getAlluser',[AuthController::class,'getAlluser']);
Route::get('/{id}',[AuthController::class,'show']);
Route::put('/{id}',[AuthController::class,'updateUser']);
Route::delete('/{id}',[AuthController::class,'deleteUser']);
