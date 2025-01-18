<?php

use Illuminate\Support\Facades\Route;

//Dashboard
use App\Http\Controllers\DashboardController as Dashboard;


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    //Dashboard
    Route::get('/', [Dashboard::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [Dashboard::class, 'index'])->name('dashboard');

    //Logout
    Route::get('/logout', [Dashboard::class, 'logout']);
});
