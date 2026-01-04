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
use App\Http\Controllers\EventController;
use App\Http\Controllers\RepositoryController;
use App\Http\Controllers\OfficeHourController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\PollController;
use App\Http\Controllers\HealthAppointmentController;
use App\Http\Controllers\PostController;



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
    // --- 11. CAMPUS EVENTS ---
    Route::resource('events', EventController::class)->only(['index','create','store','destroy']);
    Route::post('/events/{id}/register', [EventController::class, 'register'])->name('events.register');
    Route::delete('/events/{id}/unregister', [EventController::class, 'unregister'])->name('events.unregister');
    // ---12. THESIS / INTERNSHIP / PROJECT REPOSITORY ---
    Route::resource('repository', RepositoryController::class)->only(['index','create','store','destroy']);
    Route::get('/repository/{id}/download', [RepositoryController::class, 'download'])->name('repository.download');
    // ---13. FACULTY OFFICE HOURS ---
    Route::get('/office-hours', [OfficeHourController::class, 'index'])->name('office-hours.index');
    Route::get('/office-hours/create', [OfficeHourController::class, 'create'])->name('office-hours.create');
    Route::post('/office-hours', [OfficeHourController::class, 'store'])->name('office-hours.store');

    Route::post('/office-hours/{id}/book', [OfficeHourController::class, 'book'])->name('office-hours.book');
    Route::delete('/office-hours/{id}/cancel', [OfficeHourController::class, 'cancel'])->name('office-hours.cancel');

    Route::get('/office-hours/{id}/bookings', [OfficeHourController::class, 'bookings'])->name('office-hours.bookings');
    Route::delete('/office-hours/{office_hour}', [OfficeHourController::class, 'destroy'])->name('office-hours.destroy');
    // --- CAMPUS NOTICES & ALERTS ---
    Route::resource('notices', NoticeController::class)->only(['index','create','store','destroy']);
    // --- STUDENT CLUBS & ACTIVITIES ---
    Route::get('/clubs', [ClubController::class, 'index'])->name('clubs.index');
    Route::get('/clubs/create', [ClubController::class, 'create'])->name('clubs.create');
    Route::post('/clubs', [ClubController::class, 'store'])->name('clubs.store');

    Route::post('/clubs/{id}/join', [ClubController::class, 'join'])->name('clubs.join');
    Route::delete('/clubs/{id}/leave', [ClubController::class, 'leave'])->name('clubs.leave');

    Route::get('/clubs/{id}/members', [ClubController::class, 'members'])->name('clubs.members');
    // --- COMMUNITY POLLS & VOTING ---
    Route::get('/polls', [PollController::class, 'index'])->name('polls.index');
    Route::get('/polls/create', [PollController::class, 'create'])->name('polls.create');
    Route::post('/polls', [PollController::class, 'store'])->name('polls.store');

    Route::post('/polls/{id}/vote', [PollController::class, 'vote'])->name('polls.vote');

    Route::patch('/polls/{id}/toggle', [PollController::class, 'toggle'])->name('polls.toggle');
    Route::delete('/polls/{poll}', [PollController::class, 'destroy'])->name('polls.destroy');
    // --- HEALTH & WELLNESS APPOINTMENTS ---
    Route::get('/health', [HealthAppointmentController::class, 'index'])->name('health.index');
    Route::get('/health/create', [HealthAppointmentController::class, 'create'])->name('health.create');
    Route::post('/health', [HealthAppointmentController::class, 'store'])->name('health.store');

    Route::patch('/health/{id}/status', [HealthAppointmentController::class, 'updateStatus'])->name('health.updateStatus');
    Route::delete('/health/{health}', [HealthAppointmentController::class, 'destroy'])->name('health.destroy');
    

    Route::resource('gallery', App\Http\Controllers\EventPhotoController::class)->only(['index','create','store','destroy']);

    // ------------------ POSTS AND COMMENTS --------------------
    Route::get('/connect', [PostController::class, 'index'])->name('posts.index');
    Route::post('/connect', [PostController::class, 'store'])->name('posts.store');
    Route::post('/connect/{id}/comment', [PostController::class, 'storeComment'])->name('posts.comment');



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