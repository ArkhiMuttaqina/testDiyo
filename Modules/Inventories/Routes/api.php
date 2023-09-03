<?php

use Illuminate\Http\Request;
use Modules\Inventories\Http\Controllers\InventoriesController;

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

Route::prefix('inventories')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/show', [InventoriesController::class, 'show']);
    Route::post('/store', [InventoriesController::class, 'store']);
    Route::post('/update', [InventoriesController::class, 'update']);
    Route::post('/destroy', [InventoriesController::class, 'destroy']);

});

