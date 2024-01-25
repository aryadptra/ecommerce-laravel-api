<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/categories', App\Http\Controllers\Api\CategoryController::class)->except('create');
Route::apiResource('/products', App\Http\Controllers\Api\ProductController::class)->except('create', 'edit');

Route::post('/products/{id}/upload_image', [App\Http\Controllers\Api\ProductController::class, 'upload_image']);
Route::post('/products/{id_product}/delete_image/{id}', [App\Http\Controllers\Api\ProductController::class, 'delete_image']);

Route::post('/login', App\Http\Controllers\Api\LoginController::class);
Route::post('/register', App\Http\Controllers\Api\RegisterController::class);
