<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\InspectionController;
use App\Http\Controllers\DashboardController;

// get inspections
Route::get('/api/dashboard', [\App\Http\Controllers\DashboardController::class, 'getInspections']);
Route::get('/glass-factories', [\App\Http\Controllers\DashboardController::class, 'getAllGlassFactory']);
Route::get('/recycle-plants', [\App\Http\Controllers\DashboardController::class, 'getAllRecyclePlant']);

// add inspections
Route::post('/initialinspection', [\App\Http\Controllers\InspectionController::class, 'store']);
Route::post('/editinspection', [\App\Http\Controllers\InspectionController::class, 'update']);
Route::post('/deleteinspection', [\App\Http\Controllers\InspectionController::class, 'delete']);

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/general', function () {
        return Inertia::render('General');
    })->name('general');

    Route::get('/input', function () {
        return Inertia::render('Input');
    })->name('input');

    Route::get('/output', function () {
        return Inertia::render('Output');
    })->name('output');

    Route::get('/inputresult', function () {
        return Inertia::render('Inputresult');
    })->name('inputresult');

});
