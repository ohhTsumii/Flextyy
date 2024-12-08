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
Route::post('/getid', [\App\Http\Controllers\DashboardController::class, 'index']);
Route::get('/gettesttype', [\App\Http\Controllers\DashboardController::class, 'getAllTestType']);
// add inspections
Route::post('/initialinspection', [\App\Http\Controllers\InspectionController::class, 'store']);
Route::post('/editinspection', [\App\Http\Controllers\InspectionController::class, 'update']);
Route::post('/deleteinspection', [\App\Http\Controllers\InspectionController::class, 'delete']);
Route::post('/exceltest', [\App\Http\Controllers\InspectionController::class, 'excelTest']);

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

    Route::get('/testtype', function () {
        return Inertia::render('Testtype');
    })->name('testtype');

    Route::get('/cullettype', function () {
        return Inertia::render('Cullettype');
    })->name('cullettype');

    Route::get('/inspector', function () {
        return Inertia::render('Inspector');
    })->name('inspector');

    Route::get('/recycleplant', function () {
        return Inertia::render('Recycleplant');
    })->name('recycleplant');

    Route::get('/glassfactory', function () {
        return Inertia::render('Glassfactory');
    })->name('glassfactory');

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
