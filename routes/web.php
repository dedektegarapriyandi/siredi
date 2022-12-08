<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicalPrescriptionController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\NurseController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PharmacistController;
use App\Http\Controllers\PolyController;
use App\Http\Controllers\QueueController;
use App\Models\MedicalRecord;
use App\Models\Medicine;
use Faker\Guesser\Name;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('dashboard', [
            'pageTitle' => 'Dashboard'
        ]);
    });

    Route::get('/dashboard', function () {
        return view('dashboard', [
            'pageTitle' => 'Dashboard'
        ]);
    })->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('isAdmin')->group(function () {
        // user resource
        Route::resource('user', UserController::class);

        Route::prefix('users')->group(function () {
            // doctor resource
            Route::resource('dokter', DoctorController::class);

            // nurse resource
            Route::resource('perawat', NurseController::class);

            // pharmacist resource
            Route::resource('apoteker', PharmacistController::class);
        });

        // poly resource
        Route::resource('poli', PolyController::class);
    });

    // admin, pharmacist middleware
    Route::middleware('AdminPharmacist')->group(function () {
        // medicine resource
        Route::resource('obat', MedicineController::class);

        // medical prescription resource
        Route::resource('resep-obat', MedicalPrescriptionController::class);
    });

    // admin, nurse, doctor middleware
    Route::middleware('AdminDoctorNurse')->group(function () {
        // patient resource
        Route::resource('pasien', PatientController::class);

        // queue resource
        Route::resource('antrian', QueueController::class);

        // queue delete all
        Route::post('/antrian/destroy_all', [QueueController::class, 'destroyAll'])->name('antrian.destroyAll');

        // medical record route
        Route::get('antrian/{antrian}/periksa', [QueueController::class, 'check'])->name('antrian.check');
        // show detail
        Route::get('pasien/{pasien}/rekam-medis/{rekam_medis}', [MedicalRecordController::class, 'show'])->name('rekam_medis.show');

        // edit
        Route::get('pasien/{pasien}/rekam-medis/{rekam_medis}/edit', [MedicalRecordController::class, 'edit'])->name('rekam_medis.edit');

        // update
        Route::put('rekam-medis/{rekam_medis}', [MedicalRecordController::class, 'update'])->name('rekam_medis.update');

        // delete
        Route::delete('rekam_medis/{rekam_medis}', [MedicalRecordController::class, 'destroy'])->name('rekam_medis.destroy');

        // store
        Route::post('rekam-medis', [MedicalRecordController::class, 'store'])->name('rekam_medis.store');

        // prints
        Route::post('prescriptions_print/{resep_obat}', [MedicalPrescriptionController::class, 'print'])->name('print.prescriptions');
        Route::post('medical_record_print/{rekam_medis}', [MedicalRecordController::class, 'print'])->name('print.medical_record');
        Route::post('medical_record_print_all/{pasien}', [MedicalRecordController::class, 'printAll'])->name('print.medical_record_all');
    });
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'loginView'])->name('loginView');
    Route::post('/login', [AuthController::class, 'loginStore'])->name('loginStore');
});