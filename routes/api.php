<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettlementController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('zip-codes')->controller(SettlementController::class)->group(function () {
    Route::get("/{zipcode}", 'find')
        ->name("region-by-zipcode")
        ->where('zipcode', '[0-9]+');
});
