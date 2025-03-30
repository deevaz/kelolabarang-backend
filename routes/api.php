<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['jwt.auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user', [AuthController::class, 'userProfile']);
    Route::get('/products/{userId}', [ProductController::class, 'index']);
    Route::post('/products/{userId}', [ProductController::class, 'store']);
    Route::get('/products/{userId}/{id}', [ProductController::class, 'show']);
    Route::put('/products/{userId}/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{userId}/{id}', [ProductController::class, 'destroy']);
});
