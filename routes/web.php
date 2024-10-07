<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DropDownController;
use App\Http\Controllers\DependencyController;
use App\Http\Controllers\Region\RegionController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth'])->group(function(){
    
    // super admin roles 
    Route::middleware(['role:super admin'])->group(function(){
        Route::get('/dependency', [DependencyController::class, 'index'])->name('dependency');
        Route::get('/load-regions', [RegionController::class, 'index'])->name('load.regions');
        Route::post('/create-region', [RegionController::class, 'createRegion'])->name('create.region');
        
    });
    
    // region admin 
    Route::middleware(['role:region admin,role:super admin'])->group(function(){
    
    });

    //filed supervisor
    Route::middleware(['role:supervisor,super admin'])->group(function () {});
    // data staff
    Route::middleware(['role:data entry,super admin'])->group(function () {});
    // staff
    Route::middleware(['role:staff,super admin'])->group(function () {});
    // installer 
    Route::middleware(['role:installer,super admin'])->group(function () {});

    // store manager 
    Route::middleware(['role:store,super admin'])->group(function () {});

});

Route::get('/load-states', [DropDownController::class, 'loadStates'])->name('load.states');
Route::get('/load-state-lga/{id}', [DropDownController::class, 'loadStateLga'])->name('load.state.lga');






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
