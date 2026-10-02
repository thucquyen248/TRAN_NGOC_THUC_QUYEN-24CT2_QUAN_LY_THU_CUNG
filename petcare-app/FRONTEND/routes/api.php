<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\AppointmentController;

Route::apiResource('pets', PetController::class);
Route::apiResource('owners', OwnerController::class);
Route::apiResource('appointments', AppointmentController::class);
