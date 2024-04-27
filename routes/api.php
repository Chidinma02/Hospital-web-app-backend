<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\HospitalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::get('student',[UserController::class, 'index']);
Route::post('student',[UserController::class, 'store']);

// Route::get('/hospitals', [HospitalController::class, 'index']);


Route::post('/hospitals', 
    [App\Http\Controllers\Api\HospitalController::class, 'store']);
Route::get('/hospitals', 
    [App\Http\Controllers\Api\HospitalController::class, 'index']);



    // Route::post('login', [HospitalController::class, 'login']);
Route::post('register', [HospitalController::class, 'store']);
    Route::post('/login', 
    [App\Http\Controllers\Api\HospitalController::class, 'login']);
    
    Route::get('/listpatients', 
    [App\Http\Controllers\Api\HospitalController::class, 'listPatients']);

Route::get('/show', 
    [App\Http\Controllers\Api\HospitalController::class, 'show']);

    
Route::post('/logout', 
[App\Http\Controllers\Api\HospitalController::class, 'logout']);

