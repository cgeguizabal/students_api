<?php

use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');


Route::get('/v1/students', [StudentController::class, 'index']);
Route::get('/v1/student/{id}',[StudentController::class, 'studentByID']);

Route::post('/v1/newStudent', [StudentController::class, 'newStudent']);