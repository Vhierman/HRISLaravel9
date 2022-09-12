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
        Route::resource('employee', 'EmployeeController');
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
        // Route::get('history_training_eksternal/tambahhistorytrainingeksternal/{nik_karyawan}', 'HistoryTrainingEksternalController@tambahhistorytrainingeksternal')->name('history_training_eksternal.tambahhistorytrainingeksternal');
        // Route::post('history_training_eksternal/storemultipletrainingeksternal', 'HistoryTrainingEksternalController@storemultipletrainingeksternal')->name('history_training_eksternal.storemultipletrainingeksternal');
        // Route::post('history_training_eksternal/tampilmultipletrainingeksternal', 'HistoryTrainingEksternalController@tampilmultipletrainingeksternal')->name('history_training_eksternal.tampilmultipletrainingeksternal');
        // Route::resource('history_training_eksternal', 'HistoryTrainingEksternalController');
        //Inventaris
        Route::resource('inventory_motorcycle', 'InventoryMotorcycleController');
        Route::resource('inventory_car', 'InventoryCarController');
        //Cetak
        Route::get('cetak/aktifkerja/{nik_karyawan}', 'CetakController@aktifkerja')->name('cetak.aktifkerja');
        Route::get('cetak/pkwt/{nik_karyawan}', 'CetakController@pkwt')->name('cetak.pkwt');
        Route::get('cetak/pkwt_kontrak', 'CetakController@pkwt_kontrak')->name('cetak.pkwt_kontrak');
        Route::post('cetak/tampil_pkwt_kontrak', 'CetakController@tampil_pkwt_kontrak')->name('cetak.tampil_pkwt_kontrak');
        Route::get('cetak/pkwt_harian', 'CetakController@pkwt_harian')->name('cetak.pkwt_harian');
        Route::post('cetak/tampil_pkwt_harian', 'CetakController@tampil_pkwt_harian')->name('cetak.tampil_pkwt_harian');
        Route::resource('cetak', 'CetakController');
    });

Auth::routes(['verify' => true]);
