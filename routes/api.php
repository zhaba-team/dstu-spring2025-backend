<?php

declare(strict_types=1);

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:limit'])->group(function (): void {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::group(['prefix' => 'users'], static function (): void {
        Route::get('/roles', [UserController::class, 'roles']);
    });

    Route::middleware(['auth:sanctum'])->group(function (): void {
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});
