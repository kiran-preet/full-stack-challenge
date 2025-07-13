<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::resource('companies', CompanyController::class)->except(['show']);
    Route::resource('jobs', JobController::class);
});

//require __DIR__.'/auth.php';