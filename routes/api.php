<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\ForgetPasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function(){
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/forgot', [ForgetPasswordController::class, 'forgot']);

    Route::get('/login',function(){
        return response()->json([
            'message'=>'Unauthenticated',
        ]);
    })->name('login');

    Route::middleware('auth:api')->group(function(){
        Route::post('/logout', [AuthController::class, 'logout']);
    });

});
