<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Portfolio Landing Page
Route::get('/', [PortfolioController::class, 'index'])->name('home');

// Authentication Routes
Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Admin CRUD Routes
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/', function () {
        return redirect()->route('admin.projects.index');
    })->name('dashboard');

    Route::resource('projects', ProjectController::class)->except(['show']);
});
