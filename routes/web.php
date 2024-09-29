<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'role:super admin'])->group(function(){
    
});

Route::middleware(['auth', 'role:region admin'])->group(function(){

});

Route::middleware(['auth', 'role:supervisor'])->group(function(){

});

Route::middleware(['auth', 'role:staff'])->group(function(){

});

Route::middleware(['auth', 'role:installer'])->group(function(){

});

Route::middleware(['auth', 'role:store'])->group(function(){

});

Route::get('/super', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'role:super admin']);//->name('dashboard');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/main', function () {
    return Inertia::render('Main');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
