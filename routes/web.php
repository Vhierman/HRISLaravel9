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
        //Absensi
        Route::get('absensi/lihat_absensi', 'AbsensiController@lihat_absensi')->name('absensi.lihat_absensi');
        Route::get('absensi/form_edit', 'AbsensiController@form_edit')->name('absensi.form_edit');
        Route::get('absensi/form_hapus', 'AbsensiController@form_hapus')->name('absensi.form_hapus');
        Route::post('absensi/tampil_absensi', 'AbsensiController@tampil_absensi')->name('absensi.tampil_absensi');
        Route::post('absensi/tampil_edit', 'AbsensiController@tampil_edit')->name('absensi.tampil_edit');
        Route::post('absensi/tampil_hapus', 'AbsensiController@tampil_hapus')->name('absensi.tampil_hapus');
        Route::resource('absensi', 'AbsensiController');
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
        //Overtimes
        Route::get('overtime/lihat_overtime', 'OvertimeController@lihat_overtime')->name('overtime.lihat_overtime');
        Route::post('overtime/tampil_overtime', 'OvertimeController@tampil_overtime')->name('overtime.tampil_overtime');
        Route::get('overtime/form_approve_overtime', 'OvertimeController@form_approve_overtime')->name('overtime.form_approve_overtime');
        Route::post('overtime/tampil_approve_overtime', 'OvertimeController@tampil_approve_overtime')->name('overtime.tampil_approve_overtime');
        Route::post('overtime/proses_approve_overtime', 'OvertimeController@proses_approve_overtime')->name('overtime.proses_approve_overtime');
        Route::get('overtime/edit_approval/{id}', 'OvertimeController@edit_approval')->name('overtime.edit_approval');
        Route::get('overtime/form_cancel_approve_overtime', 'OvertimeController@form_cancel_approve_overtime')->name('overtime.form_cancel_approve_overtime');
        Route::post('overtime/tampil_cancel_approve_overtime', 'OvertimeController@tampil_cancel_approve_overtime')->name('overtime.tampil_cancel_approve_overtime');
        Route::post('overtime/proses_cancel_approve_overtime', 'OvertimeController@proses_cancel_approve_overtime')->name('overtime.proses_cancel_approve_overtime');
        Route::get('overtime/edit_overtime', 'OvertimeController@edit_overtime')->name('overtime.edit_overtime');
        Route::post('overtime/tampiledit_overtime', 'OvertimeController@tampiledit_overtime')->name('overtime.tampiledit_overtime');
        Route::get('overtime/form_hapus_overtime', 'OvertimeController@form_hapus_overtime')->name('overtime.form_hapus_overtime');
        Route::post('overtime/tampilhapus_overtime', 'OvertimeController@tampilhapus_overtime')->name('overtime.tampilhapus_overtime');
        Route::get('overtime/form_cetak_slip_overtime', 'OvertimeController@form_cetak_slip_overtime')->name('overtime.form_cetak_slip_overtime');
        Route::get('overtime/form_cetak_slip_karyawan_overtime', 'OvertimeController@form_cetak_slip_karyawan_overtime')->name('overtime.form_cetak_slip_karyawan_overtime');
        Route::post('overtime/hasil_slipkaryawan_overtime', 'OvertimeController@hasil_slipkaryawan_overtime')->name('overtime.hasil_slipkaryawan_overtime');
        Route::get('overtime/form_rekap_overtime', 'OvertimeController@form_rekap_overtime')->name('overtime.form_rekap_overtime');
        Route::get('overtime/form_cetak_rekap_overtime_pkwtt', 'OvertimeController@form_cetak_rekap_overtime_pkwtt')->name('overtime.form_cetak_rekap_overtime_pkwtt');
        Route::get('overtime/form_cetak_rekap_overtime_pkwt_harian', 'OvertimeController@form_cetak_rekap_overtime_pkwt_harian')->name('overtime.form_cetak_rekap_overtime_pkwt_harian');
        Route::post('overtime/form_lihat_rekap_overtime_pkwtt', 'OvertimeController@form_lihat_rekap_overtime_pkwtt')->name('overtime.form_lihat_rekap_overtime_pkwtt');
        Route::post('overtime/export_pdf_rekap_overtime_pkwtt', 'OvertimeController@export_pdf_rekap_overtime_pkwtt')->name('overtime.export_pdf_rekap_overtime_pkwtt');
        Route::post('overtime/form_lihat_rekap_overtime_pkwt_harian', 'OvertimeController@form_lihat_rekap_overtime_pkwt_harian')->name('overtime.form_lihat_rekap_overtime_pkwt_harian');
        Route::post('overtime/export_pdf_rekap_overtime_pkwt_harian', 'OvertimeController@export_pdf_rekap_overtime_pkwt_harian')->name('overtime.export_pdf_rekap_overtime_pkwt_harian');
        Route::resource('overtime', 'OvertimeController');
        //Overtimes
        //Laporan
        Route::get('laporan/rekap_gaji', 'LaporanController@rekap_gaji')->name('laporan.rekap_gaji');
        Route::post('laporan/tampil_rekap_gaji', 'LaporanController@tampil_rekap_gaji')->name('laporan.tampil_rekap_gaji');
        Route::post('laporan/export_excell_rekap_gaji', 'LaporanController@export_excell_rekap_gaji')->name('laporan.export_excell_rekap_gaji');
        Route::post('laporan/cetak_slip_gaji', 'LaporanController@cetak_slip_gaji')->name('laporan.cetak_slip_gaji');
        Route::post('laporan/cancel_rekap_gaji', 'LaporanController@cancel_rekap_gaji')->name('laporan.cancel_rekap_gaji');
        // Route::get('reports/absensi_karyawan', 'ReportsController@absensi_karyawan')->name('reports.absensi_karyawan');
        // Route::get('reports/absensi_department_pdc', 'ReportsController@absensi_department_pdc')->name('reports.absensi_department_pdc');
        // Route::get('reports/absensi_department_produksi', 'ReportsController@absensi_department_produksi')->name('reports.absensi_department_produksi');
        // Route::get('reports/absensi_department_ppc', 'ReportsController@absensi_department_ppc')->name('reports.absensi_department_ppc');
        // Route::get('reports/absensi_department_accicit', 'ReportsController@absensi_department_accicit')->name('reports.absensi_department_accicit');
        // Route::get('reports/absensi_department_hrdgadc', 'ReportsController@absensi_department_hrdgadc')->name('reports.absensi_department_hrdgadc');
        // Route::get('reports/absensi_department_marketing', 'ReportsController@absensi_department_marketing')->name('reports.absensi_department_marketing');
        // Route::get('reports/absensi_department_purchasing', 'ReportsController@absensi_department_purchasing')->name('reports.absensi_department_purchasing');
        // Route::get('reports/absensi_department_engineering', 'ReportsController@absensi_department_engineering')->name('reports.absensi_department_engineering');
        // Route::get('reports/absensi_department_quality', 'ReportsController@absensi_department_quality')->name('reports.absensi_department_quality');
        // Route::post('reports/tampil_absensi_karyawan', 'ReportsController@tampil_absensi_karyawan')->name('reports.tampil_absensi_karyawan');
        // Route::get('reports/karyawan_masuk', 'ReportsController@karyawan_masuk')->name('reports.karyawan_masuk');
        // Route::post('reports/tampil_karyawan_masuk', 'ReportsController@tampil_karyawan_masuk')->name('reports.tampil_karyawan_masuk');
        // Route::get('reports/karyawan_keluar', 'ReportsController@karyawan_keluar')->name('reports.karyawan_keluar');
        // Route::post('reports/tampil_karyawan_keluar', 'ReportsController@tampil_karyawan_keluar')->name('reports.tampil_karyawan_keluar');
        // Route::get('reports/karyawan_kontrak', 'ReportsController@karyawan_kontrak')->name('reports.karyawan_kontrak');
        // Route::get('reports/karyawan_tetap', 'ReportsController@karyawan_tetap')->name('reports.karyawan_tetap');
        // Route::get('reports/karyawan_harian', 'ReportsController@karyawan_harian')->name('reports.karyawan_harian');
        // Route::get('reports/karyawan_outsourcing', 'ReportsController@karyawan_outsourcing')->name('reports.karyawan_outsourcing');
        // Route::get('reports/inventaris_laptop', 'ReportsController@inventaris_laptop')->name('reports.inventaris_laptop');
        // Route::get('reports/inventaris_motor', 'ReportsController@inventaris_motor')->name('reports.inventaris_motor');
        // Route::get('reports/inventaris_mobil', 'ReportsController@inventaris_mobil')->name('reports.inventaris_mobil');
        Route::resource('laporan', 'LaporanController');
        //Laporan
        

       
    });

Auth::routes(['verify' => true]);
