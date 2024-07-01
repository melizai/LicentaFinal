<?php

use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
});

//Route::post('/reports', [ReportsController::class, 'generateReport'])->name('reports.generate');

#Route::post('/register', [UsersController::class, 'register']);
#Route::post('/login', [UsersController::class, 'login']);
