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

//
// Route::get('/config-clear', function() {
//     Artisan::call('config:clear'); 
//     return 'Configuration cache cleared!';
// });
// Route::get('/config-cache', function() {
//     Artisan::call('config:cache');
//     return 'Configuration cache cleared! <br> Configuration cached successfully!';
// });
// Route::get('/cache-clear', function() {
//     Artisan::call('cache:clear');
//     return 'Application cache cleared!';
// });
// Route::get('/view-cache', function() {
//     Artisan::call('view:cache');
//     return 'Compiled views cleared! <br> Blade templates cached successfully!';
// });
// Route::get('/view-clear', function() {
//     Artisan::call('view:clear');
//     return 'Compiled views cleared!';
// });
// Route::get('/route-cache', function() {
//     Artisan::call('route:cache');
//     return 'Route cache cleared! <br> Routes cached successfully!';
// });
// Route::get('/route-clear', function() {
//     Artisan::call('route:clear');
//     return 'Route cache cleared!';
// });
// Route::get('/storage-link', function() {
//     Artisan::call('storage:link');
//     return 'The links have been created.';
// });
//


Route::get('/', 'HomeController@index')->name('home');
Route::get('/facilities', 'FacilitiesController@index')->name('facilities');
Route::get('/products', 'ProductsController@index')->name('products');

// Halaman Admin
Route::prefix('admin')
    ->namespace('Admin')
    ->middleware(['auth', 'admin'])
    ->group(function(){

        Route::get('privacypolicy', 'PrivacypolicyController@index')->name('privacypolicy');
        Route::get('dashboard/ubah_password', 'DashboardController@ubah_password')->name('dashboard.ubah_password');
        Route::post('dashboard/hasil_ubah_password', 'DashboardController@hasil_ubah_password')->name('dashboard.hasil_ubah_password');
        Route::get('dashboard/form_slip_lembur_karyawan', 'DashboardController@form_slip_lembur_karyawan')->name('dashboard.form_slip_lembur_karyawan');
        Route::post('dashboard/cetak_slip_lembur_karyawan', 'DashboardController@cetak_slip_lembur_karyawan')->name('dashboard.cetak_slip_lembur_karyawan');
        Route::get('dashboard/form_absensi_karyawan', 'DashboardController@form_absensi_karyawan')->name('dashboard.form_absensi_karyawan');
        Route::post('dashboard/cetak_absensi_karyawan', 'DashboardController@cetak_absensi_karyawan')->name('dashboard.cetak_absensi_karyawan');
        Route::get('dashboard/form_ganti_foto_karyawan', 'DashboardController@form_ganti_foto_karyawan')->name('dashboard.form_ganti_foto_karyawan');
        Route::post('dashboard/hasil_ganti_foto_karyawan', 'DashboardController@hasil_ganti_foto_karyawan')->name('dashboard.hasil_ganti_foto_karyawan');
        Route::get('dashboard/logout', 'DashboardController@logout')->name('dashboard.logout');
        Route::get('/', 'DashboardController@index')->name('dashboard');
        Route::resource('dashboard-harian', 'DashboardHarianController');
        // Chart Department
        Route::resource('struktur-hrd', 'StrukturHRDController');
        // Chart Department
        //Master
        Route::resource('user', 'UserController');
        Route::resource('minimal-salaries', 'MinimalSalariesController');
        Route::resource('maksimal-bpjskesehatan', 'MaksimalBpjsKesehatanController');
        Route::resource('maksimal-bpjsketenagakerjaan', 'MaksimalUpahBpjsKetenagakerjaanController');
        Route::resource('upah_lembur_perjam', 'UpahLemburPerjamController');
        Route::resource('company', 'CompanyController');
        Route::resource('golongan', 'GolonganController');
        Route::resource('area', 'AreaController');
        Route::resource('division', 'DivisionController');
        Route::resource('position', 'PositionController');
        Route::resource('working-hour', 'WorkingHourController');
        Route::resource('school', 'SchoolController');
        //Absensi Karyawan
        Route::get('absensi/lihat_absensi', 'AbsensiController@lihat_absensi')->name('absensi.lihat_absensi');
        Route::get('absensi/form_edit', 'AbsensiController@form_edit')->name('absensi.form_edit');
        Route::get('absensi/form_hapus', 'AbsensiController@form_hapus')->name('absensi.form_hapus');
        Route::post('absensi/tampil_absensi', 'AbsensiController@tampil_absensi')->name('absensi.tampil_absensi');
        Route::post('absensi/tampil_edit', 'AbsensiController@tampil_edit')->name('absensi.tampil_edit');
        Route::post('absensi/tampil_hapus', 'AbsensiController@tampil_hapus')->name('absensi.tampil_hapus');
        Route::resource('absensi', 'AbsensiController');
        //Absensi PKL
        Route::get('absensipkl/lihat_absensi', 'AbsensiPklController@lihat_absensi')->name('absensipkl.lihat_absensi');
        Route::get('absensipkl/form_edit', 'AbsensiPklController@form_edit')->name('absensipkl.form_edit');
        Route::get('absensipkl/form_hapus', 'AbsensiPklController@form_hapus')->name('absensipkl.form_hapus');
        Route::post('absensipkl/tampil_absensi', 'AbsensiPklController@tampil_absensi')->name('absensipkl.tampil_absensi');
        Route::post('absensipkl/tampil_edit', 'AbsensiPklController@tampil_edit')->name('absensipkl.tampil_edit');
        Route::post('absensipkl/tampil_hapus', 'AbsensiPklController@tampil_hapus')->name('absensipkl.tampil_hapus');
        Route::resource('absensipkl', 'AbsensiPklController');
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
        //PKWT Shift Harian
        Route::get('proses/proses_pkwt_shift_harian', 'ProsesController@proses_pkwt_shift_harian')->name('proses.proses_pkwt_shift_harian');
        Route::post('proses/perpanjang_pkwt_shift_harian', 'ProsesController@perpanjang_pkwt_shift_harian')->name('proses.perpanjang_pkwt_shift_harian');
        //PKWT Shift Kontrak
        Route::get('proses/proses_pkwt_shift_kontrak', 'ProsesController@proses_pkwt_shift_kontrak')->name('proses.proses_pkwt_shift_kontrak');
        Route::post('proses/perpanjang_pkwt_shift_kontrak', 'ProsesController@perpanjang_pkwt_shift_kontrak')->name('proses.perpanjang_pkwt_shift_kontrak');
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
        Route::get('laporan/rekap_absensi', 'LaporanController@rekap_absensi')->name('laporan.rekap_absensi');
        Route::get('laporan/rekap_perbulan', 'LaporanController@rekap_perbulan')->name('laporan.rekap_perbulan');
        Route::get('laporan/rekap_pertahun', 'LaporanController@rekap_pertahun')->name('laporan.rekap_pertahun');
        Route::post('laporan/tampil_rekap_absensi_perbulan', 'LaporanController@tampil_rekap_absensi_perbulan')->name('laporan.tampil_rekap_absensi_perbulan');
        Route::post('laporan/tampil_rekap_absensi_pertahun', 'LaporanController@tampil_rekap_absensi_pertahun')->name('laporan.tampil_rekap_absensi_pertahun');
        Route::get('laporan/absensi_karyawan', 'LaporanController@absensi_karyawan')->name('laporan.absensi_karyawan');
        Route::post('laporan/tampil_absensi_karyawan', 'LaporanController@tampil_absensi_karyawan')->name('laporan.tampil_absensi_karyawan');
        Route::get('laporan/absensi_department_pdc_daihatsu', 'LaporanController@absensi_department_pdc_daihatsu')->name('laporan.absensi_department_pdc_daihatsu');
        Route::get('laporan/absensi_department_produksi', 'LaporanController@absensi_department_produksi')->name('laporan.absensi_department_produksi');
        Route::get('laporan/absensi_department_ppc', 'LaporanController@absensi_department_ppc')->name('laporan.absensi_department_ppc');
        Route::get('laporan/absensi_department_accicit', 'LaporanController@absensi_department_accicit')->name('laporan.absensi_department_accicit');
        Route::get('laporan/absensi_department_hrdgadc', 'LaporanController@absensi_department_hrdgadc')->name('laporan.absensi_department_hrdgadc');
        Route::get('laporan/absensi_department_marketing', 'LaporanController@absensi_department_marketing')->name('laporan.absensi_department_marketing');
        Route::get('laporan/absensi_department_purchasing', 'LaporanController@absensi_department_purchasing')->name('laporan.absensi_department_purchasing');
        Route::get('laporan/absensi_department_engineering', 'LaporanController@absensi_department_engineering')->name('laporan.absensi_department_engineering');
        Route::get('laporan/absensi_department_quality', 'LaporanController@absensi_department_quality')->name('laporan.absensi_department_quality');
        Route::get('laporan/karyawan_masuk', 'LaporanController@karyawan_masuk')->name('laporan.karyawan_masuk');
        Route::post('laporan/tampil_karyawan_masuk', 'LaporanController@tampil_karyawan_masuk')->name('laporan.tampil_karyawan_masuk');
        Route::get('laporan/karyawan_keluar', 'LaporanController@karyawan_keluar')->name('laporan.karyawan_keluar');
        Route::post('laporan/tampil_karyawan_keluar', 'LaporanController@tampil_karyawan_keluar')->name('laporan.tampil_karyawan_keluar');
        Route::get('laporan/karyawan_kontrak', 'LaporanController@karyawan_kontrak')->name('laporan.karyawan_kontrak');
        Route::get('laporan/karyawan_tetap', 'LaporanController@karyawan_tetap')->name('laporan.karyawan_tetap');
        Route::get('laporan/karyawan_harian', 'LaporanController@karyawan_harian')->name('laporan.karyawan_harian');
        Route::get('laporan/karyawan_outsourcing', 'LaporanController@karyawan_outsourcing')->name('laporan.karyawan_outsourcing');
        Route::get('laporan/inventaris_motor', 'LaporanController@inventaris_motor')->name('laporan.inventaris_motor');
        Route::get('laporan/inventaris_mobil', 'LaporanController@inventaris_mobil')->name('laporan.inventaris_mobil');
        Route::resource('laporan', 'LaporanController');
        //Laporan
        

       
    });

Auth::routes(['verify' => true]);
