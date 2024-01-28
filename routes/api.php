<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::apiResource('token', AuthController::class)->only('store');
    Route::apiResource('token', AuthController::class)->only('destroy')->middleware('auth:sanctum');
});
Route::apiResource('task', TaskController::class)->middleware('auth:sanctum');
