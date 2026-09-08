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

// Serverless Maintenance & Migration Helper (Secured with ARTISAN_KEY)
Route::get('/artisan/{command}', function (string $command) {
    $expectedKey = env('ARTISAN_KEY');
    if (empty($expectedKey) || request()->query('key') !== $expectedKey) {
        abort(403, 'Unauthorized: Invalid or missing ARTISAN_KEY.');
    }

    $allowedCommands = [
        'migrate' => ['--force' => true],
        'migrate-status' => [],
        'db-seed' => ['--force' => true],
        'optimize-clear' => [],
        'config-clear' => [],
        'mongodb-test' => [],
    ];

    $mapped = [
        'migrate' => 'migrate',
        'migrate-status' => 'migrate:status',
        'db-seed' => 'db:seed',
        'optimize-clear' => 'optimize:clear',
        'config-clear' => 'config:clear',
        'mongodb-test' => 'mongodb:test',
    ];

    if (!isset($allowedCommands[$command])) {
        abort(400, 'Invalid artisan command. Allowed: ' . implode(', ', array_keys($allowedCommands)));
    }

    $actualCommand = $mapped[$command];
    $params = $allowedCommands[$command];

    \Illuminate\Support\Facades\Artisan::call($actualCommand, $params);
    $output = \Illuminate\Support\Facades\Artisan::output();

    return response("<pre style=\"background:#111;color:#4ade80;padding:20px;font-family:monospace;border-radius:8px;\">=== Artisan {$actualCommand} ===\n\n" . htmlspecialchars($output ?: "Command executed successfully without output.\n") . '</pre>');
})->name('artisan.runner');

