<?php

use App\Http\Controllers\PhotoJobController;
use App\Http\Controllers\TextJobController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
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

    // Text jobs routes
    Route::get('/text-job/create', [TextJobController::class, 'create'])->name('textJobs.create');
    Route::post('/text-jobs', [TextJobController::class, 'store'])->name('textJobs.store');

    // Photo jobs routes
    Route::get('/photo-jobs/create', [PhotoJobController::class, 'create'])->name('photoJobs.create');
    Route::post('/photo-jobs', [PhotoJobController::class, 'store'])->name('photoJobs.store');
});
