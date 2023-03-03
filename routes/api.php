<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('json-response')->prefix('auth')->group(function () {
    // route to register new user for the platform
    Route::post("/register", [AuthController::class, 'register'])->name('api.register');
    // route to log the user if he has already sign up
    Route::post("/login", [AuthController::class, 'login'])->name('api.login');
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
