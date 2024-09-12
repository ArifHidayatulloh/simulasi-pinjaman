<?php

use App\Http\Controllers\SimulasiPinjamanController;
use Illuminate\Support\Facades\Route;

Route::get('/',[SimulasiPinjamanController::class, 'index']);
Route::post('/simulasi/process', [SimulasiPinjamanController::class, 'process']);
