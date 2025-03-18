<?php

use App\Http\Controllers\DataController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/history', [HistoryController::class, 'index'])->name('history');
Route::get('/dashboard/data', [DataController::class, 'index'])->name('dashboard.data');
