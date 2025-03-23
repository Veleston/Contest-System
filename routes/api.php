<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContestController;
use App\Http\Controllers\Api\LeaderboardController;
use App\Http\Controllers\Api\ParticipationController;
use App\Http\Controllers\Api\PrizeController;
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

// Auth Routes
Route::middleware(['api.rate.limit:auth'])->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::middleware(['auth:sanctum', 'api.rate.limit:auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

// Contest Routes
Route::middleware(['auth:sanctum', 'api.rate.limit:contests'])->group(function () {
    Route::get('/contests', [ContestController::class, 'index']);
    Route::post('/contests', [ContestController::class, 'store']);
    Route::put('/contests/{contest}', [ContestController::class, 'update']);
    Route::delete('/contests/{contest}', [ContestController::class, 'destroy']);
    Route::get('/contests/{contest}', [ContestController::class, 'show']);
});

// Participation Routes
Route::middleware(['auth:sanctum', 'api.rate.limit:participations'])->group(function () {
    Route::post('/contests/{contest}/participate', [ParticipationController::class, 'store']);
    Route::post('/participations/{participation}/submit', [ParticipationController::class, 'submit']);
    Route::get('/participations/{participation}', [ParticipationController::class, 'show']);
});

// Leaderboard Routes
Route::middleware(['auth:sanctum', 'api.rate.limit:leaderboard'])->group(function () {
    Route::get('/contests/{contest}/leaderboard', [LeaderboardController::class, 'show']);
});

// Prize Routes
Route::middleware(['auth:sanctum', 'api.rate.limit:prizes'])->group(function () {
    Route::get('/prizes', [PrizeController::class, 'index']);
    Route::get('/prizes/{prize}', [PrizeController::class, 'show']);
});