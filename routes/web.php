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
use App\Http\Controllers\Admin\FormSakitController;
use App\Http\Controllers\Admin\FormSetHariController;
use App\Http\Controllers\Admin\FormMeninggalkanTugasController;
use App\Http\Controllers\Admin\FormTgsKlrKantorController;
use App\Http\Controllers\Admin\FormCutiController;
use App\Http\Controllers\Admin\FormLemburController;
use App\Http\Controllers\Admin\RekapanController;
// User
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\IzinController;
use App\Http\Controllers\User\SakitController;
use App\Http\Controllers\User\HalfDayController;
use App\Http\Controllers\User\LeaveTaskController;
use App\Http\Controllers\User\OutOfficeAssignController;


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

// user
Route::get('/userDashboard', [UserController::class, 'index'])->middleware('auth')->name('userDashboard');
Route::get('/requestFormIzin', [IzinController::class, 'izin'])->middleware('auth')->name('requestFormIzin');
Route::post('/storeRequestIzin', [IzinController::class, 'storeRequestIzin'])->middleware('auth')->name('storeRequestIzin');
Route::get('/requestFormSakit', [SakitController::class, 'sakit'])->middleware('auth')->name('requestFormSakit');
Route::post('/storeRequestSakit', [SakitController::class, 'storeRequestSakit'])->middleware('auth')->name('storeRequestSakit');
Route::get('/requestFormHalfDay', [HalfDayController::class, 'halfDay'])->middleware('auth')->name('requestFormHalfDay');
Route::post('/storeRequestHalfDay', [HalfDayController::class, 'storeRequestHalfDay'])->middleware('auth')->name('storeRequestHalfDay');
Route::get('/requestFormLeaveTask', [LeaveTaskController::class, 'leaveTask'])->middleware('auth')->name('requestFormLeaveTask');
Route::post('/storeRequestLeaveTask', [LeaveTaskController::class, 'storeRequestLeaveTask'])->middleware('auth')->name('storeRequestLeaveTask');
Route::get('/requestFormOutOfficeAssign', [OutOfficeAssignController::class, 'outOfficeAssign'])->middleware('auth')->name('requestFormOutOfficeAssign');
Route::post('/storeRequestOutOfficeAssign', [OutOfficeAssignController::class, 'storeRequestOutOfficeAssign'])->middleware('auth')->name('storeRequestOutOfficeAssign');

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

    // Form Sakit
    Route::get('/formsakit', [FormSakitController::class, 'index'])->middleware('auth')->name('formsakit');
    Route::post('/formsakit/approve-atasan/{id}', [FormSakitController::class, 'approveAtasan'])->middleware('auth')->name('formsakit.approve-atasan');// Approve Atasan
    Route::post('/formsakit/approve-sdm/{id}', [FormSakitController::class, 'approveSdm'])->middleware('auth')->name('formsakit.approve-sdm'); // Approve SDM
    Route::post('/formsakit/unapprove-atasan/{id}', [FormSakitController::class, 'unapproveAtasan'])->middleware('auth')->name('formsakit.unapprove-atasan'); // Unapprove Atasan
    Route::post('/formsakit/unapprove-sdm/{id}', [FormSakitController::class, 'unapproveSdm'])->middleware('auth')->name('formsakit.unapprove-sdm'); // Unapprove SDM
    Route::post('/formsakit/reject-atasan/{id}', [FormSakitController::class, 'rejectAtasan'])->middleware('auth')->name('formsakit.reject-atasan'); // Reject Atasan
    Route::post('/formsakit/reject-sdm/{id}', [FormSakitController::class, 'rejectSdm'])->middleware('auth')->name('formsakit.reject-sdm'); // Reject SDM

    // Form 1/2 Hari
    Route::get('/formsethari', [FormSetHariController::class, 'index'])->middleware('auth')->name('formsethari');
    Route::post('/formsethari/approve-atasan/{id}', [FormSetHariController::class, 'approveAtasan'])->middleware('auth')->name('formsethari.approve-atasan');// Approve Atasan
    Route::post('/formsethari/approve-sdm/{id}', [FormSetHariController::class, 'approveSdm'])->middleware('auth')->name('formsethari.approve-sdm'); // Approve SDM
    Route::post('/formsethari/unapprove-atasan/{id}', [FormSetHariController::class, 'unapproveAtasan'])->middleware('auth')->name('formsethari.unapprove-atasan'); // Unapprove Atasan
    Route::post('/formsethari/unapprove-sdm/{id}', [FormSetHariController::class, 'unapproveSdm'])->middleware('auth')->name('formsethari.unapprove-sdm'); // Unapprove SDM
    Route::post('/formsethari/reject-atasan/{id}', [FormSetHariController::class, 'rejectAtasan'])->middleware('auth')->name('formsethari.reject-atasan'); // Reject Atasan
    Route::post('/formsethari/reject-sdm/{id}', [FormSetHariController::class, 'rejectSdm'])->middleware('auth')->name('formsethari.reject-sdm'); // Reject SDM

    // Form Meninggalkan Tugas
    Route::get('/formmeninggalkantugas', [FormMeninggalkanTugasController::class, 'index'])->middleware('auth')->name('formmeninggalkantugas');
    Route::post('/formmeninggalkantugas/approve-atasan/{id}', [FormMeninggalkanTugasController::class, 'approveAtasan'])->middleware('auth')->name('formmeninggalkantugas.approve-atasan');// Approve Atasan
    Route::post('/formmeninggalkantugas/approve-sdm/{id}', [FormMeninggalkanTugasController::class, 'approveSdm'])->middleware('auth')->name('formmeninggalkantugas.approve-sdm'); // Approve SDM
    Route::post('/formmeninggalkantugas/unapprove-atasan/{id}', [FormMeninggalkanTugasController::class, 'unapproveAtasan'])->middleware('auth')->name('formmeninggalkantugas.unapprove-atasan'); // Unapprove Atasan
    Route::post('/formmeninggalkantugas/unapprove-sdm/{id}', [FormMeninggalkanTugasController::class, 'unapproveSdm'])->middleware('auth')->name('formmeninggalkantugas.unapprove-sdm'); // Unapprove SDM
    Route::post('/formmeninggalkantugas/reject-atasan/{id}', [FormMeninggalkanTugasController::class, 'rejectAtasan'])->middleware('auth')->name('formmeninggalkantugas.reject-atasan'); // Reject Atasan
    Route::post('/formmeninggalkantugas/reject-sdm/{id}', [FormMeninggalkanTugasController::class, 'rejectSdm'])->middleware('auth')->name('formmeninggalkantugas.reject-sdm'); // Reject SDM

    // Form Tugas Keluar Kantor
    Route::get('/formtgsklrkantor', [FormTgsKlrKantorController::class, 'index'])->middleware('auth')->name('formtgsklrkantor');
    Route::post('/formtgsklrkantor/approve-atasan/{id}', [FormTgsKlrKantorController::class, 'approveAtasan'])->middleware('auth')->name('formtgsklrkantor.approve-atasan');// Approve Atasan
    Route::post('/formtgsklrkantor/approve-sdm/{id}', [FormTgsKlrKantorController::class, 'approveSdm'])->middleware('auth')->name('formtgsklrkantor.approve-sdm'); // Approve SDM
    Route::post('/formtgsklrkantor/unapprove-atasan/{id}', [FormTgsKlrKantorController::class, 'unapproveAtasan'])->middleware('auth')->name('formtgsklrkantor.unapprove-atasan'); // Unapprove Atasan
    Route::post('/formtgsklrkantor/unapprove-sdm/{id}', [FormTgsKlrKantorController::class, 'unapproveSdm'])->middleware('auth')->name('formtgsklrkantor.unapprove-sdm'); // Unapprove SDM
    Route::post('/formtgsklrkantor/reject-atasan/{id}', [FormTgsKlrKantorController::class, 'rejectAtasan'])->middleware('auth')->name('formtgsklrkantor.reject-atasan'); // Reject Atasan
    Route::post('/formtgsklrkantor/reject-sdm/{id}', [FormTgsKlrKantorController::class, 'rejectSdm'])->middleware('auth')->name('formtgsklrkantor.reject-sdm'); // Reject SDM

    // Form Cuti
    Route::get('/formcuti', [FormCutiController::class, 'index'])->middleware('auth')->name('formcuti');
    Route::post('/formcuti/approve-atasan/{id}', [FormCutiController::class, 'approveAtasan'])->middleware('auth')->name('formcuti.approve-atasan');// Approve Atasan
    Route::post('/formcuti/approve-sdm/{id}', [FormCutiController::class, 'approveSdm'])->middleware('auth')->name('formcuti.approve-sdm'); // Approve SDM
    Route::post('/formcuti/reject-atasan/{id}', [FormCutiController::class, 'rejectAtasan'])->middleware('auth')->name('formcuti.reject-atasan'); // Reject Atasan
    Route::post('/formcuti/reject-sdm/{id}', [FormCutiController::class, 'rejectSdm'])->middleware('auth')->name('formcuti.reject-sdm'); // Reject SDM

    // Form Lembur
    Route::get('/formlembur', [FormLemburController::class, 'index'])->middleware('auth')->name('formlembur');
    Route::post('/formlembur/approve-atasan/{id}', [FormLemburController::class, 'approveAtasan'])->middleware('auth')->name('formlembur.approve-atasan');// Approve Atasan
    Route::post('/formlembur/approve-sdm/{id}', [FormLemburController::class, 'approveSdm'])->middleware('auth')->name('formlembur.approve-sdm'); // Approve SDM
    Route::post('/formlembur/unapprove-atasan/{id}', [FormLemburController::class, 'unapproveAtasan'])->middleware('auth')->name('formlembur.unapprove-atasan'); // Unapprove Atasan
    Route::post('/formlembur/unapprove-sdm/{id}', [FormLemburController::class, 'unapproveSdm'])->middleware('auth')->name('formlembur.unapprove-sdm'); // Unapprove SDM
    Route::post('/formlembur/reject-atasan/{id}', [FormLemburController::class, 'rejectAtasan'])->middleware('auth')->name('formlembur.reject-atasan'); // Reject Atasan
    Route::post('/formlembur/reject-sdm/{id}', [FormLemburController::class, 'rejectSdm'])->middleware('auth')->name('formlembur.reject-sdm'); // Reject SDM

    // Laporan / Rekapan
    Route::get('/rekapan', [RekapanController::class, 'index'])->middleware('auth')->name('rekapan');
    Route::get('/rekapan/detail/{id}', [RekapanController::class, 'detail'])->middleware('auth')->name('rekapan.detail');

});


