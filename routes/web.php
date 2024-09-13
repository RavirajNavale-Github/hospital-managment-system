<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\appointmentController;

Route::get('/', function () {
    return view('welcome');
});
