<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\UserController;
use Illuminate\Support\Facades\Route;


//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::get('/users', [UserController::class,'index']);
Route::get('/users/{user}', [UserController::class,'show']);


Route::apiResource('invoices', \App\Http\Controllers\api\InvoiceController::class)->middleware("auth:sanctum");


Route::post("/login",[AuthController::class,'login']);
Route::post('/logout',[AuthController::class,'logout'])->middleware('auth:sanctum');
