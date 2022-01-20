<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

use App\Http\Controllers\AuthController;

// Route::resource('products', ProductController::class);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });




//public Routes

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/products/{name}', [ProductController::class, 'search']);

//Protected Routes

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
