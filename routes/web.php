<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\CafeteriaController;
use App\Http\Controllers\DealController; 
use App\Http\Controllers\HousingController;
use App\Http\Controllers\LostItemController;
use App\Http\Controllers\TransportRouteController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ResourceRequestController;
use Illuminate\Support\Facades\Artisan;
/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Authenticated Routes (All features in one safe group)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    
    // --- 1. PROFILE ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- 2. MAINTENANCE REQUESTS ---
    Route::get('/maintenance', [MaintenanceController::class, 'index'])->name('maintenance.index');
    Route::get('/maintenance/create', [MaintenanceController::class, 'create'])->name('maintenance.create');
    Route::post('/maintenance', [MaintenanceController::class, 'store'])->name('maintenance.store');

    // --- 3. CAMPUS DEALS (This was missing!) ---
    Route::resource('deals', DealController::class);

    // --- 4. CAFETERIA MENU ---
    Route::resource('cafeteria', CafeteriaController::class);

    // --- 5. VISITOR MANAGEMENT ---
    Route::get('/visitors', [VisitorController::class, 'index'])->name('visitors.index');
    Route::post('/visitors', [VisitorController::class, 'store'])->name('visitors.store');
    Route::patch('/visitors/{id}/checkout', [VisitorController::class, 'checkout'])->name('visitors.checkout');
    //----6.Housing Management---
    Route::resource('housing', HousingController::class);
    //---7.Lost and Found Management---
    Route::resource('lost-found', LostItemController::class);
    Route::patch('/lost-found/{id}/found', [LostItemController::class, 'markAsFound'])->name('lost-found.markFound');
    //---8.Transport Route Management---
    Route::resource('transport', TransportRouteController::class);
    //---9.Feedback Management---
    Route::resource('feedback', FeedbackController::class);
    //---10.Resource Request Management---
    Route::resource('resources', ResourceRequestController::class);
    Route::patch('/resources/{id}/status', [ResourceRequestController::class, 'updateStatus'])->name('resources.updateStatus');

});
// TEMPORARY: Route to set up the database on Vercel
Route::get('/run-migrations', function () {
    // 1. Wipe the database clean and create new tables
    Artisan::call('migrate:fresh --force');
    
    // 2. Add the test users (Admin, Student, etc.)
    Artisan::call('db:seed --force');
    
    return 'DONE! Database is migrated and seeded. You can now login.';
});
Route::get('/clear-cache', function() {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    return "Cache Cleared!";
});

Route::get('/reset-config', function() {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    return 'Config Cleared! Now try logging in.';
});

Route::get('/force-clear', function() {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    return "Cache Cleared! Now try logging in.";    
    
});


Route::get('/run-migrations', function () {
    // SKIP clearing cache (it causes errors if tables are missing)
    
    // 1. Create tables directly
    Artisan::call('migrate:fresh --force');
    
    // 2. Add test users
    Artisan::call('db:seed --force');
    
    return 'DONE! Database tables created successfully. You can login now.';
});

require __DIR__.'/auth.php';