<?php

use App\Exports\UsersExport;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\CheckRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JwtMiddleware;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\ExportController;





Route::get('exportAllUsers', [ExportController::class, 'exportAllUsers']);
Route::get('/exportUser/{id}', [ExportController::class, 'exportUser']);

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::apiResource('roles', RoleController::class);
Route::middleware([JwtMiddleware::class])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);





    Route::get('user', [AuthController::class, 'getUser']);







    
    Route::put('user', [AuthController::class, 'updateUser']);

    Route::middleware([CheckRole::class . ':recruiter', CheckRole::class . ':admin'])->group(function () {
        Route::apiResource('offer', OfferController::class);
        Route::get('exportAllUsers', [ExportController::class, 'exportAllUsers']);
        Route::get('/exportUser/{id}', [ExportController::class, 'exportUser']);
    });

    Route::middleware([CheckRole::class . ':candidate'])->group(function () {
        Route::post('offer/{offerId}/apply', [CandidateController::class, 'applyToOffer']);
        Route::get('getAllOffers', [OfferController::class, 'getAllOffers']);
    });
});
