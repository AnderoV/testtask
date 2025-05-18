<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

Route::get('/ping', fn () => response()->json(['sõnum' => 'API töötab']));
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/tasks', [TaskController::class, 'index']);
    Route::get('/tasks/{uuid}', [TaskController::class, 'show']);      
    Route::post('/tasks', [TaskController::class, 'store']);  
    Route::post('/tasks/{uuid}/upload', [TaskController::class, 'upload']);   
    Route::put('/tasks/{uuid}', [TaskController::class, 'update']);  
    Route::delete('/tasks/{uuid}', [TaskController::class, 'destroy']);
});