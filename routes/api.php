<?php

use App\Http\Controllers\Api\Auth\SocialController;
use App\Http\Controllers\Api\HexagramController;
use App\Http\Controllers\Api\QuestionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/logout', [SocialController::class, 'logout']);
    Route::apiResource('/question', QuestionController::class)->except(['update', 'destroy']);
    Route::apiResource('/hexagram', HexagramController::class)->except(['store', 'show', 'update', 'destroy']);
});

Route::get('/auth/{provider}', [SocialController::class, 'redirect']);
Route::get('/auth/{provider}/callback', [SocialController::class, 'callback']);

