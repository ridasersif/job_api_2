<?php

use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OfferController;
use App\Http\Middleware\CheckRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JwtMiddleware;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware([JwtMiddleware::class])->group(function () {

    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'getUser']);
    Route::put('user', [AuthController::class, 'updateUser']);
    Route::middleware([CheckRole::class.':admin',CheckRole::class.':recruiter'])->group(function(){
    
        Route::apiResource('offer',OfferController::class);
        Route::get('getMyOffers',[OfferController::class,'getMyOffers']);
       

    
    });
    Route::middleware([CheckRole::class.':candidate'])->group(function(){
        Route::get('offer',[OfferController::class,'index']);
        Route::post('offer/{offerId}/apply', [CandidateController::class, 'applyToOffer']);
    });
  
  
});