<?php

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


Route::get('/', 'HomeController@index')->name('home');
Route::get('/facilities', 'FacilitiesController@index')->name('facilities');

// Halaman Admin
Route::prefix('admin')
    ->namespace('Admin')
    ->middleware(['auth', 'admin'])
    ->group(function(){
        Route::get('/', 'DashboardController@index')->name('dashboard');
        Route::resource('minimal-salaries', 'MinimalSalariesController');
        Route::resource('maksimal-bpjskesehatan', 'MaksimalBpjsKesehatanController');
        Route::resource('maksimal-bpjsketenagakerjaan', 'MaksimalUpahBpjsKetenagakerjaanController');
        Route::resource('company', 'CompanyController');
        Route::resource('golongan', 'GolonganController');
        Route::resource('area', 'AreaController');
        Route::resource('division', 'DivisionController');
        Route::resource('position', 'PositionController');
        Route::resource('working-hour', 'WorkingHourController');
        Route::resource('school', 'SchoolController');
        //Karyawan
        Route::get('employee/export_excel', 'EmployeeController@export_excel')->name('employee.export_excel');
        Route::resource('employee', 'EmployeeController');
        //Karyawan Keluar
        Route::get('employee_out/export_excel', 'EmployeeOutController@export_excel')->name('employee_out.export_excel');
        Route::resource('employee_out', 'EmployeeOutController');
        //History Kontrak
        Route::get('history_contract/tambahhistorykontrak/{nik_karyawan}', 'HistoryContractController@tambahhistorykontrak')->name('history_contract.tambahhistorykontrak');
        Route::resource('history_contract', 'HistoryContractController');
        //History Jabatan
        Route::get('history_position/tambahhistoryjabatan/{nik_karyawan}', 'HistoryPositionController@tambahhistoryjabatan')->name('history_position.tambahhistoryjabatan');
        Route::resource('history_position', 'HistoryPositionController');
        //History Keluarga
        Route::get('history_family/tambahhistoryfamily/{nik_karyawan}', 'HistoryFamilyController@tambahhistoryfamily')->name('history_family.tambahhistoryfamily');
        Route::resource('history_family', 'HistoryFamilyController');
        //History Training Internal
        Route::get('history_training_internal/tambahhistorytraininginternal/{nik_karyawan}', 'HistoryTrainingInternalController@tambahhistorytraininginternal')->name('history_training_internal.tambahhistorytraininginternal');
        Route::post('history_training_internal/storemultipletraininginternal', 'HistoryTrainingInternalController@storemultipletraininginternal')->name('history_training_internal.storemultipletraininginternal');
        Route::post('history_training_internal/tampilmultipletraininginternal', 'HistoryTrainingInternalController@tampilmultipletraininginternal')->name('history_training_internal.tampilmultipletraininginternal');
        Route::resource('history_training_internal', 'HistoryTrainingInternalController');
        //History Training Eksternal
        Route::get('history_training_eksternal/tambahhistorytrainingeksternal/{nik_karyawan}', 'HistoryTrainingEksternalController@tambahhistorytrainingeksternal')->name('history_training_eksternal.tambahhistorytrainingeksternal');
        Route::post('history_training_eksternal/storemultipletrainingeksternal', 'HistoryTrainingEksternalController@storemultipletrainingeksternal')->name('history_training_eksternal.storemultipletrainingeksternal');
        Route::post('history_training_eksternal/tampilmultipletrainingeksternal', 'HistoryTrainingEksternalController@tampilmultipletrainingeksternal')->name('history_training_eksternal.tampilmultipletrainingeksternal');
        Route::resource('history_training_eksternal', 'HistoryTrainingEksternalController');
        // Students
        Route::resource('student', 'StudentController');
        //Inventaris
        Route::resource('inventory_motorcycle', 'InventoryMotorcycleController');
        Route::resource('inventory_car', 'InventoryCarController');
        //Cetak
        Route::get('cetak/aktifkerja/{nik_karyawan}', 'CetakController@aktifkerja')->name('cetak.aktifkerja');
        Route::get('cetak/penilaian_karyawan', 'CetakController@penilaian_karyawan')->name('cetak.penilaian_karyawan');
        Route::post('cetak/tampil_penilaian_karyawan', 'CetakController@tampil_penilaian_karyawan')->name('cetak.tampil_penilaian_karyawan');
        Route::get('cetak/pkwt/{nik_karyawan}', 'CetakController@pkwt')->name('cetak.pkwt');
        Route::get('cetak/pkwt_kontrak', 'CetakController@pkwt_kontrak')->name('cetak.pkwt_kontrak');
        Route::post('cetak/tampil_pkwt_kontrak', 'CetakController@tampil_pkwt_kontrak')->name('cetak.tampil_pkwt_kontrak');
        Route::get('cetak/pkwt_harian', 'CetakController@pkwt_harian')->name('cetak.pkwt_harian');
        Route::post('cetak/tampil_pkwt_harian', 'CetakController@tampil_pkwt_harian')->name('cetak.tampil_pkwt_harian');
        Route::resource('cetak', 'CetakController');
        // Process
        //PKWT Kontrak
        Route::get('proses/proses_pkwt_kontrak', 'ProsesController@proses_pkwt_kontrak')->name('proses.proses_pkwt_kontrak');
        Route::post('proses/tampil_pkwt_kontrak', 'ProsesController@tampil_pkwt_kontrak')->name('proses.tampil_pkwt_kontrak');
        Route::post('proses/prosess_pkwt_kontrak/{akhir_kontrak}', 'ProsesController@prosess_pkwt_kontrak')->name('proses.prosess_pkwt_kontrak');
        Route::post('proses/perpanjang_pkwt_kontrak', 'ProsesController@perpanjang_pkwt_kontrak')->name('proses.perpanjang_pkwt_kontrak');
        //PKWT Harian
        Route::get('proses/proses_pkwt_harian', 'ProsesController@proses_pkwt_harian')->name('proses.proses_pkwt_harian');
        Route::post('proses/tampil_pkwt_harian', 'ProsesController@tampil_pkwt_harian')->name('proses.tampil_pkwt_harian');
        Route::post('proses/prosess_pkwt_harian', 'ProsesController@prosess_pkwt_harian')->name('proses.prosess_pkwt_harian');
        Route::post('proses/perpanjang_pkwt_harian', 'ProsesController@perpanjang_pkwt_harian')->name('proses.perpanjang_pkwt_harian');
        //Rekon Salary
        Route::get('proses/proses_rekon_salary', 'ProsesController@proses_rekon_salary')->name('proses.proses_rekon_salary');
        Route::post('proses/tampil_rekon_salary', 'ProsesController@tampil_rekon_salary')->name('proses.tampil_rekon_salary');
        Route::post('proses/hasil_rekon_salary', 'ProsesController@hasil_rekon_salary')->name('proses.hasil_rekon_salary');
        Route::get('proses/export_excell_rekon_salary', 'ProsesController@export_excell_rekon_salary')->name('proses.export_excell_rekon_salary');
        Route::get('proses/edit_salary/{employees_id}', 'ProsesController@edit_salary')->name('proses.edit_salary');
        Route::post('proses/hasil_edit_salary/{employees_id}', 'ProsesController@hasil_edit_salary')->name('proses.hasil_edit_salary');
        //
        Route::resource('proses', 'ProsesController');
    });

Auth::routes(['verify' => true]);
