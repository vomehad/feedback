<?php

use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/', [IndexController::class, 'feedback']);
});

Route::get('locale/{locale}', function ($locale) {
    Session::put('locale', $locale);

    return redirect()->back();
})->name('locale');

Route::get('/login', [IndexController::class, 'auth'])->name('login');
