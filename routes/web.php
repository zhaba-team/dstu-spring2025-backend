<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/api.php';
require __DIR__.'/auth.php';

Route::get('/', static function () {
    return view('welcome');
});
