<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/bookAppointment', function () {
    return view('appointment');
});

Route::get('/regitration', function () {
    return view('regitration');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/addDoctor', function () {
    return view('addDoctor');
});
