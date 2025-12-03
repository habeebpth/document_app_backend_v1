<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DocumentApiController;
use App\Http\Controllers\Api\CategoryApiController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);


Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

Route::post('/change-password', [AuthController::class, 'changePassword']);

   Route::get('/get-documents', [DocumentApiController::class, 'index']);
   Route::get('/get-categories', [CategoryApiController::class, 'index']);
   Route::get('/get-document/{id}', [DocumentApiController::class, 'show']);
   Route::post('/documents/search-all', [DocumentApiController::class, 'searchAll']);

  Route::get('/dashboard', [DocumentApiController::class, 'dashboard']);


});
