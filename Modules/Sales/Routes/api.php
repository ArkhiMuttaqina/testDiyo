<?php

use Illuminate\Http\Request;
use Modules\Sales\Http\Controllers\SalesController;

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

Route::prefix('sales')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/show', [SalesController::class, 'show']);
    Route::post('/store', [SalesController::class, 'store']);
    Route::post('/update', [SalesController::class, 'update']);
    Route::post('/destroy', [SalesController::class, 'destroy']);
});
