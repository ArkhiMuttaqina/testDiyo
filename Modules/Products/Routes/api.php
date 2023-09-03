<?php

use Illuminate\Http\Request;
use Modules\Products\Http\Controllers\ProductsController;

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

Route::prefix('products')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/show', [ProductsController::class, 'show']);
    Route::post('/store', [ProductsController::class, 'store']);
    Route::post('/update', [ProductsController::class, 'update']);
    Route::post('/destroy', [ProductsController::class, 'destroy']);
});
