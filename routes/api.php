<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockOutController;

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
    // ! ganti password
    Route::post('/change-password', [AuthController::class, 'changePassword']);

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user', [AuthController::class, 'userProfile']);
    Route::put('/user/{id}', [AuthController::class, 'updateProfile']);
    Route::delete('/user/{id}', [AuthController::class, 'deleteAccount']);

    //! crud products
    Route::get('/products/{userId}', [ProductController::class, 'index']);
    Route::get('/products/{userId}/{category}', [ProductController::class, 'showByCategory']);
    Route::post('/products/{userId}', [ProductController::class, 'store']);
    Route::get('/products/{userId}/{id}', [ProductController::class, 'show']);
    Route::put('/products/{userId}/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{userId}/{id}', [ProductController::class, 'destroy']);

    //! crud suppliers
    Route::get('/suppliers/{userId}', [SuppliersController::class, 'index']);
    Route::post('/suppliers/{userId}', [SuppliersController::class, 'store']);
    Route::get('/suppliers/{userId}/{id}', [SuppliersController::class, 'show']);
    Route::put('/suppliers/{userId}/{id}', [SuppliersController::class, 'update']);
    Route::delete('/suppliers/{userId}/{id}', [SuppliersController::class, 'destroy']);

    //! crud business
    Route::get('/business/{userId}', [BusinessController::class, 'index']);
    Route::post('/business/{userId}', [BusinessController::class, 'store']);
    Route::get('/business/{userId}/{id}', [BusinessController::class, 'show']);
    Route::put('/business/{userId}/{id}', [BusinessController::class, 'update']);
    Route::delete('/business/{userId}/{id}', [BusinessController::class, 'destroy']);

    //! crud stock-in
    Route::get('/stockin/{userId}', [StockInController::class, 'index']);
    Route::post('/stockin/{userId}', [StockInController::class, 'store']);
    Route::get('/stockin/{userId}/{id}', [StockInController::class, 'show']);
    Route::put('/stockin/{userId}/{id}', [StockInController::class, 'update']);
    Route::delete('/stockin/{userId}/{id}', [StockInController::class, 'destroy']);

    //! crud stock-out
    Route::get('/stockout/{userId}', [StockOutController::class, 'index']);
    Route::post('/stockout/{userId}', [StockOutController::class, 'store']);
    Route::get('/stockout/{userId}/{id}', [StockOutController::class, 'show']);
    Route::put('/stockout/{userId}/{id}', [StockOutController::class, 'update']);
    Route::delete('/stockout/{userId}/{id}', [StockOutController::class, 'destroy']);
});
