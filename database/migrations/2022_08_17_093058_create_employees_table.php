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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->integer('golongans_id');
            $table->integer('companies_id');
            $table->integer('area_id');
            $table->integer('divisions_id');
            $table->integer('positions_id');
            $table->integer('working_hours_id');
            $table->string('nik_karyawan');
            $table->string('nama_karyawan');
            $table->string('email_karyawan');
            $table->string('nomor_absen');
            $table->string('nomor_npwp');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('agama');
            $table->string('jenis_kelamin');
            $table->string('pendidikan_terakhir');
            $table->string('nomor_handphone');
            $table->string('golongan_darah');
            $table->string('alamat');
            $table->string('rt');
            $table->string('rw');
            $table->string('kelurahan');
            $table->string('kecamatan');
            $table->string('kota');
            $table->string('provinsi');
            $table->string('kode_pos');
            $table->string('foto_karyawan');
            $table->string('foto_ktp');
            $table->string('foto_npwp');
            $table->string('foto_kk');
            $table->string('nomor_bpjskesehatan');
            $table->string('nomor_bpjsketenagakerjaan');
            $table->string('nomor_kartu_keluarga');
            $table->string('status_nikah');
            $table->string('nama_ibu');
            $table->string('nama_ayah');
            $table->date('tanggal_mulai_kerja');
            $table->date('tanggal_akhir_kerja');
            $table->string('status_kerja');
            $table->string('nama_bank');
            $table->integer('nomor_rekening');
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
        Schema::dropIfExists('employees');
    }
};
