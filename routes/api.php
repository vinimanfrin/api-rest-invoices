<?php

use App\Http\Controllers\api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::get('/users', [UserController::class,'index']);
Route::get('/users/{user}', [UserController::class,'show']);


Route::get('/invoices', [\App\Http\Controllers\api\InvoiceController::class,'index']);
Route::get('/invoices/{invoice}', [\App\Http\Controllers\api\InvoiceController::class,'show']);

