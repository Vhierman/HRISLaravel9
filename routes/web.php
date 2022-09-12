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
