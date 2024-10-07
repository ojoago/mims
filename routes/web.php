<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DropDownController;
use App\Http\Controllers\DependencyController;
use App\Http\Controllers\Region\FeederController;
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
        Route::get('/feeders', [FeederController::class, 'index'])->name('feeders');
        Route::get('/load-all-regions', [RegionController::class, 'index'])->name('load.regions');
        Route::post('/create-region', [RegionController::class, 'createRegion'])->name('create.region');

        Route::post('/create-33kv-feeder', [FeederController::class, 'create33kvFeeder'])->name('create.33kv.feeder');
        Route::get('/load-feeder-33', [FeederController::class, 'load33kvFeeder']);//->name('create.33kv.feeder');
        Route::post('/create-11kv-feeder', [FeederController::class, 'create11kvFeeder'])->name('create.11kv.feeder');
        Route::get('/load-feeder-11', [FeederController::class, 'load11kvFeeder']);//->name('create.33kv.feeder');
        
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
Route::get('/load-state-regions', [DropDownController::class, 'loadStateRegion']);//->name('load.regions');
Route::get('/load-regions/{state}', [DropDownController::class, 'loadRegions']);//->name('load.regions');
Route::get('/load-regions-admin', [DropDownController::class, 'loadRegionsAdmin']);//->name('load.regions');
Route::get('/load-feeder-33/{region}', [DropDownController::class, 'loadRegion33KvFeeder']);//->name('load.regions');






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
