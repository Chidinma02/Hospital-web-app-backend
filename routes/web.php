<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::get('/', function () {
    return view('welcome');
 });

// Route::get('/student',[UserController::class, 'index']);
// // Route::get('students',[UserController::class, 'index']);

// Route::get('student',[UserController::class, 'index']);