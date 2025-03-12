<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Reception\ReceptionController;
use App\Http\Middleware\ReceptionMiddleware;
use App\Http\Controllers\MedicalTechnologist\MedicalTechnologistController;
use App\Http\Middleware\MedicalTechnologistMiddleware;
use App\Http\Controllers\RadiologicTechnologist\RadiologicTechnologistController;
use App\Http\Middleware\RadiologicTechnologistMiddleware;

use App\Http\Controllers\Physician\PhysicianController;
use App\Http\Middleware\PhysicianMiddleware;

// Dashboard Routes
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


// This Routes are for Admin type of user.
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');

    // Users
    Route::prefix('users')->group(function () {
        Route::get('/', [AdminController::class, 'usersIndex'])->name('users.index');
        Route::get('/create', [AdminController::class, 'usersCreate'])->name('users.create');
        Route::post('/', [AdminController::class, 'usersStore'])->name('users.store');
        Route::get('/{user}', [AdminController::class, 'usersShow'])->name('users.show');
        Route::get('/{user}/edit', [AdminController::class, 'usersEdit'])->name('users.edit');
        Route::put('/{user}', [AdminController::class, 'usersUpdate'])->name('users.update');
        Route::delete('/{user}', [AdminController::class, 'usersDestroy'])->name('users.destroy');
    });

    // Patients
    Route::prefix('patients')->group(function () {
        Route::get('/', [AdminController::class, 'patientsIndex'])->name('patients.index');
        Route::get('/create', [AdminController::class, 'patientsCreate'])->name('patients.create');
        Route::post('/', [AdminController::class, 'patientsStore'])->name('patients.store');
        Route::get('/{patient}', [AdminController::class, 'patientsShow'])->name('patients.show');
        Route::get('/{patient}/edit', [AdminController::class, 'patientsEdit'])->name('patients.edit');
        Route::put('/{patient}', [AdminController::class, 'patientsUpdate'])->name('patients.update');
        Route::delete('/{patient}', [AdminController::class, 'patientsDestroy'])->name('patients.destroy');
        Route::get('/{patient}/transactions', [AdminController::class, 'showPatientTransactions'])->name('patients.transactions');
        Route::get('/{patient_id}/transactions/search', [AdminController::class, 'searchPatientTransactions'])
        ->name('transactions.search');
    });

  // Laboratory Services
Route::prefix('laboratory-services')->group(function () {
    Route::get('/', [AdminController::class, 'laboratoryServicesIndex'])->name('laboratory_services.index');
    Route::get('/create', [AdminController::class, 'laboratoryServicesCreate'])->name('laboratory_services.create');
    Route::post('/categories', [AdminController::class, 'categoryStore'])->name('categories.store');
    Route::post('/', [AdminController::class, 'laboratoryServicesStore'])->name('laboratory_services.store');
    Route::get('/{service}', [AdminController::class, 'laboratoryServicesShow'])->name('laboratory_services.show');
    Route::get('/{service}/edit', [AdminController::class, 'laboratoryServicesEdit'])->name('laboratory_services.edit');
    Route::put('/{service}', [AdminController::class, 'laboratoryServicesUpdate'])->name('laboratory_services.update');
    Route::delete('/{service}', [AdminController::class, 'laboratoryServicesDestroy'])->name('laboratory_services.destroy');
    Route::get('/{service}/amount', [AdminController::class, 'laboratoryServicesGetAmount'])->name('laboratory_services.get_amount');
});


    // Queues
    Route::prefix('queues')->group(function () {
        Route::get('/', [AdminController::class, 'queuesIndex'])->name('queues.index');
        Route::post('/', [AdminController::class, 'queuesStore'])->name('queues.store');
        Route::get('/{queue}', [AdminController::class, 'queuesShow'])->name('queues.show');
        Route::put('/{queue}/mark-as-done', [AdminController::class, 'queuesMarkAsDone'])->name('queues.markAsDone');
        Route::get('/transaction/{transaction}', [AdminController::class, 'queuesShowTransaction'])->name('queues.show-transaction');
        Route::post('/{queue}/start-process', [AdminController::class, 'queuesStartProcess'])->name('queues.start-process');
        Route::post('/{queue}/update-service', [AdminController::class, 'queuesUpdateService'])->name('queues.update-service');
        Route::put('/queues/{queue}/release', [AdminController::class, 'queuesRelease'])
    ->name('queues.release');
    });
    Route::get('/queue/display', [AdminController::class, 'queuesDisplay'])->name('queue.display');

 // Releasings
 Route::get('releasings', [AdminController::class, 'releasingsIndex'])->name('releasings.index');
    Route::post('releasings/{id}/upload', [AdminController::class, 'releasingsUpload'])->name('releasings.upload');
    Route::get('releasings/{id}/view', [AdminController::class, 'releasingsView'])->name('releasings.view');
    Route::post('/releasings/{id}/sendEmail', [AdminController::class, 'releasingsSendEmail'])->name('releasings.sendEmail');
    Route::post('/releasings/{id}/release', [AdminController::class, 'releasingsRelease'])->name('releasings.release');
    Route::delete('/releasings/{releasing}', [AdminController::class, 'releasingsDestroy'])
    ->name('releasings.destroy');
   // Transactions
   Route::prefix('transactions')->group(function () {
    Route::get('/', [AdminController::class, 'transactionsIndex'])->name('transactions.index');
    Route::get('/create', [AdminController::class, 'transactionsCreate'])->name('transactions.create');
    Route::post('/', [AdminController::class, 'transactionsStore'])->name('transactions.store');
    Route::get('/{transaction}', [AdminController::class, 'transactionsShow'])->name('transactions.show');
    Route::get('/{transaction}/edit', [AdminController::class, 'transactionsEdit'])->name('transactions.edit');
    Route::put('/{transaction}', [AdminController::class, 'transactionsUpdate'])->name('transactions.update');
    Route::delete('/{transaction}', [AdminController::class, 'transactionsDestroy'])->name('transactions.destroy');
    Route::post('/{transaction}/mark-paid', [AdminController::class, 'transactionsMarkPaid'])->name('transactions.markPaid');
    Route::get('/{patient_id}/search', [AdminController::class, 'transactionsSearch'])->name('transactions.search');
});
 // Consultations Routes
 Route::prefix('consultations')->group(function () {
    Route::get('consultations', [AdminController::class, 'consultationsIndex'])->name('consultations.index');
    Route::get('consultations/create', [AdminController::class, 'consultationsCreate'])->name('consultations.create');
    Route::post('consultations', [AdminController::class, 'consultationsStore'])->name('consultations.store');
    Route::get('consultations/{id}', [AdminController::class, 'consultationsShow'])->name('consultations.show');
    Route::get('consultations/{id}/edit', [AdminController::class, 'consultationsEdit'])->name('consultations.edit');
    Route::put('consultations/{id}', [AdminController::class, 'consultationsUpdate'])->name('consultations.update');
    Route::delete('consultations/{id}', [AdminController::class, 'consultationsDestroy'])->name('consultations.destroy');
    Route::post('/consultations/{id}/forward', [AdminController::class, 'consultationsForward'])->name('consultations.forward');

});
});


// This Routes are for Reception type of user.
Route::middleware(['auth', ReceptionMiddleware::class])->prefix('reception')->name('reception.')->group(function () {
    Route::get('/', [ReceptionController::class, 'index'])->name('index');

    // Users
    Route::prefix('users')->group(function () {
        Route::get('/', [ReceptionController::class, 'usersIndex'])->name('users.index');
        Route::get('/create', [ReceptionController::class, 'usersCreate'])->name('users.create');
        Route::post('/', [ReceptionController::class, 'usersStore'])->name('users.store');
        Route::get('/{user}', [ReceptionController::class, 'usersShow'])->name('users.show');
        Route::get('/{user}/edit', [ReceptionController::class, 'usersEdit'])->name('users.edit');
        Route::put('/{user}', [ReceptionController::class, 'usersUpdate'])->name('users.update');
        Route::delete('/{user}', [ReceptionController::class, 'usersDestroy'])->name('users.destroy');
    });

    // Patients
    Route::prefix('patients')->group(function () {
        Route::get('/', [ReceptionController::class, 'patientsIndex'])->name('patients.index');
        Route::get('/create', [ReceptionController::class, 'patientsCreate'])->name('patients.create');
        Route::post('/', [ReceptionController::class, 'patientsStore'])->name('patients.store');
        Route::get('/{patient}', [ReceptionController::class, 'patientsShow'])->name('patients.show');
        Route::get('/{patient}/edit', [ReceptionController::class, 'patientsEdit'])->name('patients.edit');
        Route::put('/{patient}', [ReceptionController::class, 'patientsUpdate'])->name('patients.update');
        Route::delete('/{patient}', [ReceptionController::class, 'patientsDestroy'])->name('patients.destroy');
        Route::get('/{patient}/transactions', [ReceptionController::class, 'showPatientTransactions'])->name('patients.transactions');
        Route::get('/{patient_id}/transactions/search', [ReceptionController::class, 'searchPatientTransactions'])
        ->name('transactions.search');
    });

    // Laboratory Services
    Route::prefix('laboratory-services')->group(function () {
        Route::get('/', [ReceptionController::class, 'laboratoryServicesIndex'])->name('laboratory_services.index');
        Route::get('/create', [ReceptionController::class, 'laboratoryServicesCreate'])->name('laboratory_services.create');
        Route::post('/categories', [ReceptionController::class, 'categoryStore'])->name('categories.store');
        Route::post('/', [ReceptionController::class, 'laboratoryServicesStore'])->name('laboratory_services.store');
        Route::get('/{service}', [ReceptionController::class, 'laboratoryServicesShow'])->name('laboratory_services.show');
        Route::get('/{service}/edit', [ReceptionController::class, 'laboratoryServicesEdit'])->name('laboratory_services.edit');
        Route::put('/{service}', [ReceptionController::class, 'laboratoryServicesUpdate'])->name('laboratory_services.update');
        Route::delete('/{service}', [ReceptionController::class, 'laboratoryServicesDestroy'])->name('laboratory_services.destroy');
        Route::get('/{service}/amount', [ReceptionController::class, 'laboratoryServicesGetAmount'])->name('laboratory_services.get_amount');
    });

    // Queues
    Route::prefix('queues')->group(function () {
        Route::get('/', [ReceptionController::class, 'queuesIndex'])->name('queues.index');
        Route::post('/', [ReceptionController::class, 'queuesStore'])->name('queues.store');
        Route::get('/{queue}', [ReceptionController::class, 'queuesShow'])->name('queues.show');
        Route::put('/{queue}/mark-as-done', [ReceptionController::class, 'queuesMarkAsDone'])->name('queues.markAsDone');
        Route::get('/transaction/{transaction}', [ReceptionController::class, 'queuesShowTransaction'])->name('queues.show-transaction');
        Route::post('/{queue}/start-process', [ReceptionController::class, 'queuesStartProcess'])->name('queues.start-process');
        Route::post('/{queue}/update-service', [ReceptionController::class, 'queuesUpdateService'])->name('queues.update-service');
        Route::put('/queues/{queue}/release', [ReceptionController::class, 'queuesRelease'])
    ->name('queues.release');
    });
    Route::get('/queue/display', [ReceptionController::class, 'queuesDisplay'])->name('queue.display');

    // Releasings
    Route::get('releasings', [ReceptionController::class, 'releasingsIndex'])->name('releasings.index');
    Route::post('releasings/{id}/upload', [ReceptionController::class, 'releasingsUpload'])->name('releasings.upload');
    Route::get('releasings/{id}/view', [ReceptionController::class, 'releasingsView'])->name('releasings.view');
    Route::post('/releasings/{id}/sendEmail', [ReceptionController::class, 'releasingsSendEmail'])->name('releasings.sendEmail');
    Route::post('/releasings/{id}/release', [ReceptionController::class, 'releasingsRelease'])->name('releasings.release');

    // Transactions
    Route::prefix('transactions')->group(function () {
        Route::get('/', [ReceptionController::class, 'transactionsIndex'])->name('transactions.index');
        Route::get('/create', [ReceptionController::class, 'transactionsCreate'])->name('transactions.create');
        Route::post('/', [ReceptionController::class, 'transactionsStore'])->name('transactions.store');
        Route::get('/{transaction}', [ReceptionController::class, 'transactionsShow'])->name('transactions.show');
        Route::get('/{transaction}/edit', [ReceptionController::class, 'transactionsEdit'])->name('transactions.edit');
        Route::put('/{transaction}', [ReceptionController::class, 'transactionsUpdate'])->name('transactions.update');
        Route::delete('/{transaction}', [ReceptionController::class, 'transactionsDestroy'])->name('transactions.destroy');
        Route::post('/{transaction}/mark-paid', [ReceptionController::class, 'transactionsMarkPaid'])->name('transactions.markPaid');
        Route::get('/{patient_id}/search', [ReceptionController::class, 'transactionsSearch'])->name('transactions.search');
    });
});

// This Routes are for Medical Technologist type of user.
Route::middleware(['auth', MedicalTechnologistMiddleware::class])->prefix('medicaltechnologist')->name('medicaltechnologist.')->group(function () {
    Route::get('/', [MedicalTechnologistController::class, 'index'])->name('index');

    // Users
    Route::prefix('users')->group(function () {
        Route::get('/', [MedicalTechnologistController::class, 'usersIndex'])->name('users.index');
        Route::post('/', [MedicalTechnologistController::class, 'usersStore'])->name('users.store');
        Route::get('/{user}', [MedicalTechnologistController::class, 'usersShow'])->name('users.show');
        Route::get('/{user}/edit', [MedicalTechnologistController::class, 'usersEdit'])->name('users.edit');
        Route::put('/{user}', [MedicalTechnologistController::class, 'usersUpdate'])->name('users.update');
    });

    // Patients
    Route::prefix('patients')->group(function () {
        Route::get('/', [MedicalTechnologistController::class, 'patientsIndex'])->name('patients.index');
        Route::post('/', [MedicalTechnologistController::class, 'patientsStore'])->name('patients.store');
        Route::get('/{patient}', [MedicalTechnologistController::class, 'patientsShow'])->name('patients.show');
        Route::get('/{patient}/edit', [MedicalTechnologistController::class, 'patientsEdit'])->name('patients.edit');
        Route::put('/{patient}', [MedicalTechnologistController::class, 'patientsUpdate'])->name('patients.update');
        Route::get('/{patient}/transactions', [MedicalTechnologistController::class, 'showPatientTransactions'])->name('patients.transactions');
        Route::get('/{patient_id}/transactions/search', [MedicalTechnologistController::class, 'searchPatientTransactions'])
        ->name('transactions.search');
    });

    // Laboratory Services
    Route::prefix('laboratory-services')->group(function () {
        Route::get('/', [MedicalTechnologistController::class, 'laboratoryServicesIndex'])->name('laboratory_services.index');
        Route::post('/categories', [MedicalTechnologistController::class, 'categoryStore'])->name('categories.store');
        Route::post('/', [MedicalTechnologistController::class, 'laboratoryServicesStore'])->name('laboratory_services.store');
        Route::get('/{service}', [MedicalTechnologistController::class, 'laboratoryServicesShow'])->name('laboratory_services.show');
        Route::put('/{service}', [MedicalTechnologistController::class, 'laboratoryServicesUpdate'])->name('laboratory_services.update');
        Route::get('/{service}/amount', [MedicalTechnologistController::class, 'laboratoryServicesGetAmount'])->name('laboratory_services.get_amount');
    });

    // Queues
    Route::prefix('queues')->group(function () {
        Route::get('/', [MedicalTechnologistController::class, 'queuesIndex'])->name('queues.index');
        Route::post('/', [MedicalTechnologistController::class, 'queuesStore'])->name('queues.store');
        Route::get('/{queue}', [MedicalTechnologistController::class, 'queuesShow'])->name('queues.show');
        Route::put('/{queue}/mark-as-done', [MedicalTechnologistController::class, 'queuesMarkAsDone'])->name('queues.markAsDone');
        Route::get('/transaction/{transaction}', [MedicalTechnologistController::class, 'queuesShowTransaction'])->name('queues.show-transaction');
        Route::post('/{queue}/start-process', [MedicalTechnologistController::class, 'queuesStartProcess'])->name('queues.start-process');
        Route::post('/{queue}/update-service', [MedicalTechnologistController::class, 'queuesUpdateService'])->name('queues.update-service');
        Route::put('/queues/{queue}/release', [MedicalTechnologistController::class, 'queuesRelease'])
    ->name('queues.release');
    });
    Route::get('/queue/display', [MedicalTechnologistController::class, 'queuesDisplay'])->name('queue.display');

    // Releasings
    Route::get('releasings', [MedicalTechnologistController::class, 'releasingsIndex'])->name('releasings.index');
    Route::post('releasings/{id}/upload', [MedicalTechnologistController::class, 'releasingsUpload'])->name('releasings.upload');
    Route::get('releasings/{id}/view', [MedicalTechnologistController::class, 'releasingsView'])->name('releasings.view');
    Route::post('/releasings/{id}/sendEmail', [MedicalTechnologistController::class, 'releasingsSendEmail'])->name('releasings.sendEmail');
    Route::post('/releasings/{id}/release', [MedicalTechnologistController::class, 'releasingsRelease'])->name('releasings.release');
    Route::delete('/releasings/{releasing}', [MedicalTechnologistController::class, 'releasingsDestroy'])
    ->name('releasings.destroy');
});


// This Routes are for Radiologic Technologist type of user.
Route::middleware(['auth', RadiologicTechnologistMiddleware::class])->prefix('radiologictechnologist')->name('radiologictechnologist.')->group(function () {
    Route::get('/', [RadiologicTechnologistController::class, 'index'])->name('index');

    // Users
    Route::prefix('users')->group(function () {
        Route::get('/', [RadiologicTechnologistController::class, 'usersIndex'])->name('users.index');
        Route::post('/', [RadiologicTechnologistController::class, 'usersStore'])->name('users.store');
        Route::get('/{user}', [RadiologicTechnologistController::class, 'usersShow'])->name('users.show');
        Route::get('/{user}/edit', [RadiologicTechnologistController::class, 'usersEdit'])->name('users.edit');
        Route::put('/{user}', [RadiologicTechnologistController::class, 'usersUpdate'])->name('users.update');
    });

    // Patients
    Route::prefix('patients')->group(function () {
        Route::get('/', [RadiologicTechnologistController::class, 'patientsIndex'])->name('patients.index');
        Route::post('/', [RadiologicTechnologistController::class, 'patientsStore'])->name('patients.store');
        Route::get('/{patient}', [RadiologicTechnologistController::class, 'patientsShow'])->name('patients.show');
        Route::put('/{patient}', [RadiologicTechnologistController::class, 'patientsUpdate'])->name('patients.update');
        Route::get('/{patient}/transactions', [RadiologicTechnologistController::class, 'showPatientTransactions'])->name('patients.transactions');
        Route::get('/{patient_id}/transactions/search', [RadiologicTechnologistController::class, 'searchPatientTransactions'])
        ->name('transactions.search');
    });

    // Laboratory Services
    Route::prefix('laboratory-services')->group(function () {
        Route::get('/', [RadiologicTechnologistController::class, 'laboratoryServicesIndex'])->name('laboratory_services.index');
        Route::post('/categories', [RadiologicTechnologistController::class, 'categoryStore'])->name('categories.store');
        Route::post('/', [RadiologicTechnologistController::class, 'laboratoryServicesStore'])->name('laboratory_services.store');
        Route::get('/{service}', [RadiologicTechnologistController::class, 'laboratoryServicesShow'])->name('laboratory_services.show');
        Route::put('/{service}', [RadiologicTechnologistController::class, 'laboratoryServicesUpdate'])->name('laboratory_services.update');
        Route::get('/{service}/amount', [RadiologicTechnologistController::class, 'laboratoryServicesGetAmount'])->name('laboratory_services.get_amount');
    });

    // Queues
    Route::prefix('queues')->group(function () {
        Route::get('/', [RadiologicTechnologistController::class, 'queuesIndex'])->name('queues.index');
        Route::post('/', [RadiologicTechnologistController::class, 'queuesStore'])->name('queues.store');
        Route::get('/{queue}', [RadiologicTechnologistController::class, 'queuesShow'])->name('queues.show');
        Route::put('/{queue}/mark-as-done', [RadiologicTechnologistController::class, 'queuesMarkAsDone'])->name('queues.markAsDone');
        Route::get('/transaction/{transaction}', [RadiologicTechnologistController::class, 'queuesShowTransaction'])->name('queues.show-transaction');
        Route::post('/{queue}/start-process', [RadiologicTechnologistController::class, 'queuesStartProcess'])->name('queues.start-process');
        Route::post('/{queue}/update-service', [RadiologicTechnologistController::class, 'queuesUpdateService'])->name('queues.update-service');
        Route::put('/queues/{queue}/release', [RadiologicTechnologistController::class, 'queuesRelease'])
    ->name('queues.release');
    });
    Route::get('/queue/display', [RadiologicTechnologistController::class, 'queuesDisplay'])->name('queue.display');

    // Releasings
    Route::get('releasings', [RadiologicTechnologistController::class, 'releasingsIndex'])->name('releasings.index');
    Route::post('releasings/{id}/upload', [RadiologicTechnologistController::class, 'releasingsUpload'])->name('releasings.upload');
    Route::get('releasings/{id}/view', [RadiologicTechnologistController::class, 'releasingsView'])->name('releasings.view');
    Route::post('/releasings/{id}/sendEmail', [RadiologicTechnologistController::class, 'releasingsSendEmail'])->name('releasings.sendEmail');
    Route::post('/releasings/{id}/release', [RadiologicTechnologistController::class, 'releasingsRelease'])->name('releasings.release');
    Route::delete('/releasings/{releasing}', [RadiologicTechnologistController::class, 'releasingsDestroy'])
    ->name('releasings.destroy');

});


// This Routes are for Physician type of user.
Route::middleware(['auth', PhysicianMiddleware::class])->prefix('physician')->name('physician.')->group(function () {
    Route::get('/', [PhysicianController::class, 'index'])->name('index');

    // Users
    Route::prefix('users')->group(function () {
        Route::get('/', [PhysicianController::class, 'usersIndex'])->name('users.index');
        Route::post('/', [PhysicianController::class, 'usersStore'])->name('users.store');
        Route::get('/{user}', [PhysicianController::class, 'usersShow'])->name('users.show');
        Route::get('/{user}/edit', [PhysicianController::class, 'usersEdit'])->name('users.edit');
        Route::put('/{user}', [PhysicianController::class, 'usersUpdate'])->name('users.update');
    });

    // Patients
    Route::prefix('patients')->group(function () {
        Route::get('/', [PhysicianController::class, 'patientsIndex'])->name('patients.index');
        Route::post('/', [PhysicianController::class, 'patientsStore'])->name('patients.store');
        Route::get('/{patient}', [PhysicianController::class, 'patientsShow'])->name('patients.show');
        Route::put('/{patient}', [PhysicianController::class, 'patientsUpdate'])->name('patients.update');
        Route::get('/{patient}/transactions', [PhysicianController::class, 'showPatientTransactions'])->name('patients.transactions');
        Route::get('/{patient_id}/transactions/search', [PhysicianController::class, 'searchPatientTransactions'])
        ->name('transactions.search');
    });

    // Laboratory Services
    Route::prefix('laboratory-services')->group(function () {
        Route::get('/', [PhysicianController::class, 'laboratoryServicesIndex'])->name('laboratory_services.index');
        Route::post('/categories', [PhysicianController::class, 'categoryStore'])->name('categories.store');
        Route::post('/', [PhysicianController::class, 'laboratoryServicesStore'])->name('laboratory_services.store');
        Route::get('/{service}', [PhysicianController::class, 'laboratoryServicesShow'])->name('laboratory_services.show');
        Route::put('/{service}', [PhysicianController::class, 'laboratoryServicesUpdate'])->name('laboratory_services.update');
        Route::get('/{service}/amount', [PhysicianController::class, 'laboratoryServicesGetAmount'])->name('laboratory_services.get_amount');
    });

    // Queues
    Route::prefix('queues')->group(function () {
        Route::get('/', [PhysicianController::class, 'queuesIndex'])->name('queues.index');
        Route::post('/', [PhysicianController::class, 'queuesStore'])->name('queues.store');
        Route::get('/{queue}', [PhysicianController::class, 'queuesShow'])->name('queues.show');
        Route::put('/{queue}/mark-as-done', [PhysicianController::class, 'queuesMarkAsDone'])->name('queues.markAsDone');
        Route::get('/transaction/{transaction}', [PhysicianController::class, 'queuesShowTransaction'])->name('queues.show-transaction');
        Route::post('/{queue}/start-process', [PhysicianController::class, 'queuesStartProcess'])->name('queues.start-process');
        Route::post('/{queue}/update-service', [PhysicianController::class, 'queuesUpdateService'])->name('queues.update-service');
        Route::put('/queues/{queue}/release', [PhysicianController::class, 'queuesRelease'])
    ->name('queues.release');
    });
    Route::get('/queue/display', [PhysicianController::class, 'queuesDisplay'])->name('queue.display');

    // Releasings
    Route::get('releasings', [PhysicianController::class, 'releasingsIndex'])->name('releasings.index');
    Route::post('releasings/{id}/upload', [PhysicianController::class, 'releasingsUpload'])->name('releasings.upload');
    Route::get('releasings/{id}/view', [PhysicianController::class, 'releasingsView'])->name('releasings.view');
    Route::post('/releasings/{id}/sendEmail', [PhysicianController::class, 'releasingsSendEmail'])->name('releasings.sendEmail');
    Route::post('/releasings/{id}/release', [PhysicianController::class, 'releasingsRelease'])->name('releasings.release');


 // Consultations Routes
    Route::prefix('consultations')->group(function () {
        Route::get('consultations', [PhysicianController::class, 'consultationsIndex'])->name('consultations.index');
        Route::get('consultations/create', [PhysicianController::class, 'consultationsCreate'])->name('consultations.create');
        Route::post('consultations', [PhysicianController::class, 'consultationsStore'])->name('consultations.store');
        Route::get('consultations/{id}', [PhysicianController::class, 'consultationsShow'])->name('consultations.show');
        Route::get('consultations/{id}/edit', [PhysicianController::class, 'consultationsEdit'])->name('consultations.edit');
        Route::put('consultations/{id}', [PhysicianController::class, 'consultationsUpdate'])->name('consultations.update');
        Route::delete('consultations/{id}', [PhysicianController::class, 'consultationsDestroy'])->name('consultations.destroy');
        Route::post('/consultations/{id}/forward', [PhysicianController::class, 'consultationsForward'])->name('consultations.forward');

});
});

// Logout confirmation page route
Route::get('/logout', [LoginController::class, 'logoutConfirm'])->name('logout.confirm');

// Logout route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
// Welcome Route
Route::get('/', function () {
    return view('welcome');
});

// Public routes for patient registration
Route::get('/patient-registration', function () {
    return view('patient-registration');
})->name('patient-registration');

Route::post('/patient/store', [PatientController::class, 'store'])
    ->name('patient.store');

Route::get('/patient/registration-slip/{patient}', [PatientController::class, 'showRegistrationSlip'])
    ->name('patient.registration-slip');


// Include additional routes if necessary (e.g., password reset, profile routes)
require __DIR__.'/auth.php';
