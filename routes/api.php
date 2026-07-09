<?php

use App\Http\Controllers\Api\Frontend\TrackingController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:30,1')->group(function () {
    Route::get('/frontend/tracking', [TrackingController::class, 'show']);
});
