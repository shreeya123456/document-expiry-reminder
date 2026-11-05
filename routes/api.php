<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocumentController;

// Authentication Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
Route::get('/documents/statistics', [DocumentController::class, 'statistics']);
    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Document Routes
    Route::get('/documents', [DocumentController::class, 'index']);
    Route::post('/documents', [DocumentController::class, 'store']);

    // Upcoming and Expired Documents
    Route::get('/documents/upcoming', [DocumentController::class, 'upcoming']);
    Route::get('/documents/expired', [DocumentController::class, 'expired']);

    // Show, Update and Delete
    Route::get('/documents/{id}', [DocumentController::class, 'show']);
    Route::put('/documents/{id}', [DocumentController::class, 'update']);
    Route::delete('/documents/{id}', [DocumentController::class, 'destroy']);

});
