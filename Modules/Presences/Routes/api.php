<?php

use Illuminate\Http\Request;
use Modules\Presences\Http\Controllers\PresencesController;

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

// Route::middleware('auth:api')->get('/presences', function (Request $request) {
//     return $request->user();
// });

Route::prefix('presences')->middleware(['auth:sanctum'])->group(function () {

    Route::post('checklog', [PresencesController::class, 'store']);
});
