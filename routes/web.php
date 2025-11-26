<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PPICDashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function(){
    return view('auth.login');
});

Route::get('/ppic/dashboard', [PPICDashboardController::class, 'index'])->name('ppic.dashboard');
