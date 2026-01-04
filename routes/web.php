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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    
    // -----------------------PROFILE --------------------
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ----------------MAINTENANCE REQUESTS ------------
    Route::get('/maintenance', [MaintenanceController::class, 'index'])->name('maintenance.index');
    Route::get('/maintenance/create', [MaintenanceController::class, 'create'])->name('maintenance.create');
    Route::post('/maintenance', [MaintenanceController::class, 'store'])->name('maintenance.store');

    // ---------------------- CAMPUS DEALS -----------------------
    Route::resource('deals', DealController::class);

    // ------------------------CAFETERIA MENU ---------------------
    Route::resource('cafeteria', CafeteriaController::class);

    // ------------------------VISITOR MANAGEMENT -------------------
    Route::get('/visitors', [VisitorController::class, 'index'])->name('visitors.index');
    Route::post('/visitors', [VisitorController::class, 'store'])->name('visitors.store');
    Route::patch('/visitors/{id}/checkout', [VisitorController::class, 'checkout'])->name('visitors.checkout');
    //----------------------------Housing Management------------------
    Route::resource('housing', HousingController::class);
    //------------------------Lost and Found Management----------------
    Route::resource('lost-found', LostItemController::class);
    Route::patch('/lost-found/{id}/found', [LostItemController::class, 'markAsFound'])->name('lost-found.markFound');
    //-------------------------Transport Route Management-----------------
    Route::resource('transport', TransportRouteController::class);
    //-------------------------Feedback Management-----------------------
    Route::resource('feedback', FeedbackController::class);
    //-------------------------Resource Request Management---------------
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


Route::get('/fix-db', function () {
    // 1. Force Clean Connection
    DB::purge();
    DB::reconnect();

    // 2. DESTROY GHOST TABLES (The Nuclear Option)
    // We use "CASCADE" to delete linked data automatically
    DB::statement('DROP TABLE IF EXISTS users CASCADE');
    DB::statement('DROP TABLE IF EXISTS sessions CASCADE');
    DB::statement('DROP TABLE IF EXISTS password_reset_tokens CASCADE');
    DB::statement('DROP TABLE IF EXISTS cache CASCADE');
    DB::statement('DROP TABLE IF EXISTS cache_locks CASCADE');
    DB::statement('DROP TABLE IF EXISTS jobs CASCADE');
    DB::statement('DROP TABLE IF EXISTS job_batches CASCADE');
    DB::statement('DROP TABLE IF EXISTS failed_jobs CASCADE');

    // 3. NOW run the migrations on the truly empty DB
    Artisan::call('migrate:fresh --force');
    Artisan::call('db:seed --force');
    
    return 'DONE! Ghost tables deleted and database rebuilt. Go to /login';
});

require __DIR__.'/auth.php';