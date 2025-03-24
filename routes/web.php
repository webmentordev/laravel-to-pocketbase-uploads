<?php

use App\Http\Controllers\PocketbaseController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/upload', [PocketbaseController::class, 'store'])->name('upload');
