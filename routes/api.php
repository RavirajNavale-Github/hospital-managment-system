<?php

use App\Http\Controllers\API\AppointmentController;
use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Admin Routes
Route::post('signup', [AuthController::class, 'signup']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//Appointment Routes
Route::post('appointments', [AppointmentController::class, 'bookAppointment']);
