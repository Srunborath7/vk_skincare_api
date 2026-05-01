<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductDetailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'store']);
});
Route::prefix('auth')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/users', [AuthController::class, 'index']);
    
});
Route::prefix("categories")->middleware('auth:sanctum')->group(function(){
    Route::get("/search",[CategoryController::class, "search"]);
    Route::get("/" , [CategoryController::class, "index"]);
    Route::post("/",[CategoryController::class, "store"]);
    Route::put("/{id}",[CategoryController::class, "update"]);
    Route::delete("/{id}",[CategoryController::class, "destroy"]);
});
Route::prefix("brands")->middleware('auth:sanctum')->group(function(){
    Route::get("/search",[BrandController::class, "search"]);
    Route::get("/" , [BrandController::class, "index"]);
    Route::post("/",[BrandController::class, "store"]);
    Route::put("/{id}",[BrandController::class, "update"]);
    Route::delete("/{id}",[BrandController::class, "destroy"]);
});

Route::prefix("products")->middleware('auth:sanctum')->group(function(){
    Route::get("/tags",[ProductController::class, "getTags"]);
    Route::get("/search",[ProductController::class, "search"]);
    Route::get("/" , [ProductController::class, "index"]);
    Route::post("/",[ProductController::class, "store"]);
    Route::put("/{id}",[ProductController::class, "update"]);
    Route::delete("/{id}",[ProductController::class, "destroy"]);
});

Route::prefix("product-details")->middleware('auth:sanctum')->group(function(){
    Route::get("/" , [ProductDetailController::class, "index"]);
    Route::post("/",[ProductDetailController::class, "store"]);
    Route::put("/{id}",[ProductDetailController::class, "update"]);
    Route::delete("/{id}",[ProductDetailController::class, "destroy"]);
});