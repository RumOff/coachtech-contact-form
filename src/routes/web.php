<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;

Route::get('/', [ContactController::class, 'index']);
Route::post('/confirm', [ContactController::class, 'confirm']);
Route::post('/confirm/store', [ContactController::class, 'store']);
Route::get('/thanks', [ContactController::class, 'thanks']);

// admin
Route::get('/admin', [AdminController::class, 'index']);
Route::get('/search', [AdminController::class, 'search']);