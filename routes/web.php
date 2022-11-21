<?php

use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function() {
    Route::get('/', [IndexController::class, 'feedback'])->name('main');
    Route::post('/', [IndexController::class, 'feedbackStore'])->name('web.store');
});

Route::get('/login', [IndexController::class, 'auth'])->name('auth_form');
Route::post('/login', [IndexController::class, 'login'])->name('login');
Route::get('/logout', [IndexController::class, 'logout'])->name('logout');
