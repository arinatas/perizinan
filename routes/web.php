<?php

use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
// Admin
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AkunController;
use App\Http\Controllers\Admin\AtasanController;
use App\Http\Controllers\Admin\JenisCutiController;
use App\Http\Controllers\Admin\CutiController;
use App\Http\Controllers\Admin\FormIzinController;
// User
use App\Http\Controllers\User\UserController;

use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

Route::get('/login', [LoginController::class, 'index'])->middleware('guest')->name('login');
Route::get('/', [LoginController::class, 'index'])->middleware('guest')->name('login');

Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('password', [ChangePasswordController::class, 'edit'])->name('password.edit')->middleware('auth');
Route::patch('password', [ChangePasswordController::class, 'update'])->name('password.edit')->middleware('auth');

Route::get('/adminDashboard', [AdminController::class, 'index'])->middleware('auth')->name('adminDashboard');

Route::get('/userDashboard', [UserController::class, 'index'])->middleware('auth')->name('userDashboard');

Route::middleware(['admin'])->group(function () {
    // Dashboard
    Route::get('/adminDashboard', [AdminController::class, 'index'])->middleware('auth')->name('adminDashboard');

    // Master Akun
    Route::get('/akun', [AkunController::class, 'index'])->middleware('auth')->name('akun');
    Route::post('/akun', [AkunController::class, 'store'])->middleware('auth')->name('insert.akun');
    Route::get('/editAkun/{id}', [AkunController::class, 'edit'])->middleware('auth')->name('edit.akun');
    Route::post('/updateAkun/{id}', [AkunController::class, 'update'])->middleware('auth')->name('update.akun');
    Route::delete('/deleteAkun/{id}', [AkunController::class, 'destroy'])->middleware('auth')->name('destroy.akun');
    Route::get('/resetAkun/{id}', [AkunController::class, 'reset'])->middleware('auth')->name('reset.akun');
    Route::post('/resetupdateAkun/{id}', [AkunController::class, 'resetupdate'])->middleware('auth')->name('resetupdate.akun');

    // Master Atasan
    Route::get('/atasan', [AtasanController::class, 'index'])->middleware('auth')->name('atasan');
    Route::post('/atasan', [AtasanController::class, 'store'])->middleware('auth')->name('insert.atasan');
    Route::get('/editAtasan/{id}', [AtasanController::class, 'edit'])->middleware('auth')->name('edit.atasan');
    Route::post('/updateAtasan/{id}', [AtasanController::class, 'update'])->middleware('auth')->name('update.atasan');
    Route::delete('/deleteAtasan/{id}', [AtasanController::class, 'destroy'])->middleware('auth')->name('destroy.atasan');
    
    // Master Jenis Cuti
    Route::get('/jeniscuti', [JenisCutiController::class, 'index'])->middleware('auth')->name('jeniscuti');
    Route::post('/jeniscuti', [JenisCutiController::class, 'store'])->middleware('auth')->name('insert.jeniscuti');
    Route::get('/editJeniscuti/{id}', [JenisCutiController::class, 'edit'])->middleware('auth')->name('edit.jeniscuti');
    Route::post('/updateJeniscuti/{id}', [JenisCutiController::class, 'update'])->middleware('auth')->name('update.jeniscuti');
    Route::delete('/deleteJeniscuti/{id}', [JenisCutiController::class, 'destroy'])->middleware('auth')->name('destroy.jeniscuti');

    // Master Cuti
    Route::get('/cuti', [CutiController::class, 'index'])->middleware('auth')->name('cuti');
    Route::post('/cuti', [CutiController::class, 'store'])->middleware('auth')->name('insert.cuti');
    Route::get('/editCuti/{id}', [CutiController::class, 'edit'])->middleware('auth')->name('edit.cuti');
    Route::post('/updateCuti/{id}', [CutiController::class, 'update'])->middleware('auth')->name('update.cuti');
    Route::delete('/deleteCuti/{id}', [CutiController::class, 'destroy'])->middleware('auth')->name('destroy.cuti');

    // Form Izin
    Route::get('/formizin', [FormIzinController::class, 'index'])->middleware('auth')->name('formizin');
    Route::post('/formizin/approve-atasan/{id}', [FormIzinController::class, 'approveAtasan'])->middleware('auth')->name('formizin.approve-atasan');// Approve Atasan
    Route::post('/formizin/approve-sdm/{id}', [FormIzinController::class, 'approveSdm'])->middleware('auth')->name('formizin.approve-sdm'); // Approve SDM
    Route::post('/formizin/unapprove-atasan/{id}', [FormIzinController::class, 'unapproveAtasan'])->middleware('auth')->name('formizin.unapprove-atasan'); // Unapprove Atasan
    Route::post('/formizin/unapprove-sdm/{id}', [FormIzinController::class, 'unapproveSdm'])->middleware('auth')->name('formizin.unapprove-sdm'); // Unapprove SDM
    Route::post('/formizin/reject-atasan/{id}', [FormIzinController::class, 'rejectAtasan'])->middleware('auth')->name('formizin.reject-atasan'); // Reject Atasan
    Route::post('/formizin/reject-sdm/{id}', [FormIzinController::class, 'rejectSdm'])->middleware('auth')->name('formizin.reject-sdm'); // Reject SDM




});


