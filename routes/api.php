<?php

use App\Http\Controllers\Api\FeedbackController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::post('feedbacks/{id}/restore', [FeedbackController::class, 'restore'])->name('feedbacks.restore');
    Route::post('feedbacks/{id}/processed', [FeedbackController::class, 'processed'])->name('feedbacks.processed');
    Route::resource('feedbacks', FeedbackController::class)->except(['create', 'update']);

    Route::get('logout');
});

Route::post('login');
