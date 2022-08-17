<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees_outs', function (Blueprint $table) {
            $table->id();
            $table->integer('employees_id');
            $table->integer('companies_id');
            $table->integer('golongans_id');
            $table->integer('areas_id');
            $table->integer('division_id');
            $table->integer('positions_id');
            $table->string('nama_karyawan_keluar');
            $table->string('nomor_npwp_karyawan_keluar');
            $table->string('email_karyawan_keluar');
            $table->string('nomor_handphone_karyawan_keluar');
            $table->string('tempat_lahir_karyawan_keluar');
            $table->string('tanggal_lahir_karyawan_keluar');
            $table->string('nomor_bpjsketenagakerjaan_karyawan_keluar');
            $table->string('nomor_bpjskesehatan_karyawan_keluar');
            $table->string('nomor_rekening_karyawan_keluar');
            $table->string('pendidikan_terakhir_karyawan_keluar');
            $table->string('jenis_kelamin_karyawan_keluar');
            $table->string('agama_karyawan_keluar');
            $table->string('alamat_karyawan_keluar');
            $table->string('rt_karyawan_keluar');
            $table->string('rw_karyawan_keluar');
            $table->string('kelurahan_karyawan_keluar');
            $table->string('kecamatan_karyawan_keluar');
            $table->string('kota_karyawan_keluar');
            $table->string('provinsi_karyawan_keluar');
            $table->string('kode_pos_karyawan_keluar');
            $table->string('nomor_absen_karyawan_keluar');
            $table->string('golongan_darah_karyawan_keluar');
            $table->string('nomor_kartu_keluarga_karyawan_keluar');
            $table->string('status_nikah_karyawan_keluar');
            $table->string('nama_ayah_karyawan_keluar');
            $table->string('nama_ibu_karyawan_keluar');
            $table->date('tanggal_masuk_karyawan_keluar');
            $table->date('tanggal_keluar_karyawan_keluar');
            $table->string('status_kerja_karyawan_keluar');
            $table->string('keterangan_keluar');
            $table->string('input_oleh');
            $table->string('edit_oleh');
            $table->string('hapus_oleh');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees_outs');
    }
};
