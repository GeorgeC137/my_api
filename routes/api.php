<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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


// Route::resource('products', ProductController::class,);


// Public Routes
Route::get('/products', [ProductController::class, 'index']);


Route::get('/products/{id}', [ProductController::class, 'show']);


Route::get('/products/search/{name}', [ProductController::class, 'search']);


Route::post('/register', [UserController::class, 'register']);


Route::post('/login', [UserController::class, 'login']);




// Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/products', [ProductController::class, 'store']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);

});

