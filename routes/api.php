<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/ping', function () {
    return response()->json(['sõnum' => 'API töötab']);
});

Route::post('/login', [AuthController::class, 'login']);