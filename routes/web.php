<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::prefix('api')->group(base_path('routes/api.php'));

Route::get('/', static function () {
    return view('welcome');
});
