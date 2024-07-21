<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaboratoryServiceController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\ReleasingController;


// Dashboard Routes
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


// User Management routes
Route::middleware('auth')->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
});

// Patient Management routes
Route::middleware('auth')->group(function () {
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::get('/patients/create', [PatientController::class, 'create'])->name('patients.create');
    Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
    Route::get('/patients/{id}/edit', [PatientController::class, 'edit'])->name('patients.edit');
    Route::put('/patients/{id}', [PatientController::class, 'update'])->name('patients.update');
    Route::delete('/patients/{id}', [PatientController::class, 'destroy'])->name('patients.destroy');
    Route::get('/patients/{patient}/transactions', [PatientController::class, 'showTransactions'])->name('patients.transactions');
    Route::get('/patients/{patient_id}/transactions/search', 'App\Http\Controllers\TransactionController@search')
    ->name('transactions.search');
    Route::get('/patients/{patient}', [PatientController::class, 'show'])->name('patients.show');
});

// Laboratory Services Management routes
Route::middleware('auth')->group(function () {
    Route::get('/laboratory_services', [LaboratoryServiceController::class, 'index'])->name('laboratory_services.index');
    Route::get('/laboratory_services/create', [LaboratoryServiceController::class, 'create'])->name('laboratory_services.create');
    Route::post('/laboratory_services', [LaboratoryServiceController::class, 'store'])->name('laboratory_services.store');
    Route::post('/categories', [LaboratoryServiceController::class, 'storeCategory'])->name('categories.store');
    Route::get('/laboratory_services/{id}/edit', [LaboratoryServiceController::class, 'edit'])->name('laboratory_services.edit');
    Route::put('/laboratory_services/{id}', [LaboratoryServiceController::class, 'update'])->name('laboratory_services.update');
    Route::delete('/laboratory_services/{id}', [LaboratoryServiceController::class, 'destroy'])->name('laboratory_services.destroy');
    Route::get('/laboratory_services/{id}', [LaboratoryServiceController::class, 'show'])->name('laboratory_services.show');
});
// Transactions Management routes
Route::middleware('auth')->group(function () {
    // Define route for transactions index
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
    Route::post('/transactions/{id}/mark-paid', [TransactionController::class, 'markPaid'])->name('transactions.markPaid');
    
});

//Queue Management
    Route::middleware('auth')->group(function () {
    Route::get('/queue', [QueueController::class, 'index'])->name('queue.index');
    Route::resource('queues', QueueController::class)->except(['create', 'edit', 'update', 'destroy']);
    Route::put('queues/{queue}/mark-as-done', [QueueController::class, 'markAsDone'])->name('queues.markAsDone');
    Route::get('/queue/display', [QueueController::class, 'display'])->name('queue.display');
});

//Releasing management
Route::middleware(['auth'])->group(function () {
    Route::get('releasings', [ReleasingController::class, 'index'])->name('releasings.index');
    Route::post('releasings/{id}/upload', [ReleasingController::class, 'upload'])->name('releasings.upload');
    Route::get('releasings/{id}/view', [ReleasingController::class, 'view'])->name('releasings.view');
    Route::post('/releasings/{id}/sendEmail', [ReleasingController::class, 'sendEmail'])->name('releasings.sendEmail');
    Route::post('/releasings/{id}/release', [ReleasingController::class, 'release'])->name('releasings.release');
});
// Logout confirmation page route
Route::get('/logout', [LoginController::class, 'logoutConfirm'])->name('logout.confirm');

// Logout route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Welcome Route
Route::get('/', function () {
    return view('welcome');
});

// Include additional routes if necessary (e.g., password reset, profile routes)
require __DIR__.'/auth.php';
