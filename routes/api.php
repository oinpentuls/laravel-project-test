<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);

    return ['token' => $token->plainTextToken];
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']);

    Route::post('/users', [UserController::class, 'store']);
});
