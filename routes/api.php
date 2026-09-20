<?php

use App\Http\Controllers\PageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('v1/')->middleware('auth:sanctum')->group(function () {
    Route::post('/pages', [PageController::class, 'store']);
});
