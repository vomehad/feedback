<?php

use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/', [IndexController::class, 'feedback'])->name('main');
});

Route::get('/login', [IndexController::class, 'auth'])->name('auth_form');
Route::post('/login', [IndexController::class, 'login'])->name('login');
