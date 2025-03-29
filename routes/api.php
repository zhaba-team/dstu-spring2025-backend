<?php

declare(strict_types=1);

use App\Http\Controllers\Api\EmailVerificationController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:limit'])->group(static function (): void {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::group(['prefix' => 'users'], static function (): void {
        Route::get('/{id}', [UserController::class, 'show']);
        Route::get('/roles', [UserController::class, 'roles']);
    });

    Route::middleware(['auth:sanctum'])->group(static function (): void {
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::group(['prefix' => 'emails'], static function (): void {
            Route::get('/send-verify-code', [EmailVerificationController::class, 'send'])->middleware(['throttle:send-verify-code']);
            Route::post('/verify-code', [EmailVerificationController::class, 'verify']);
        });

        Route::group(['prefix' => 'users'], static function (): void {
            Route::post('/{userId}', [UserController::class, 'update'])->middleware('checkUserOwnership');
        });
    });
});
