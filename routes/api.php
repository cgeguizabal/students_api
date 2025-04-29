<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/student', function (Request $request) {
    return $request->user();
})->middleware('auth:api');


Route::get('/v1/students', [StudentController::class, 'index']);
Route::get('/v1/student/{id}',[StudentController::class, 'studentByID']);

Route::post('/v1/newStudent', [StudentController::class, 'newStudent']);

Route::patch('/v1/updateStudentInfo/{id}', [StudentController::class,'updateStudentInfo']);

Route::delete('/v1/deleteStudent/{id}', [StudentController::class, 'deleteStudent']);

Route::get('/v1/auth', function(){
    return response()->json([
        'message' => 'Access denied, please login to continue',
    ], 401);
})->name('login');

Route::post('/v1/login', [AuthenticationController::class, 'login']);