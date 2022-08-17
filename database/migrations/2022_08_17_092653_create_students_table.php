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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->integer('schools_id');
            $table->integer('divisions_id');
            $table->date('tanggal_masuk_pkl');
            $table->date('tanggal_selesai_pkl');
            $table->string('nis_siswa');
            $table->string('nama_siswa');
            $table->string('tempat_lahir_siswa');
            $table->date('tanggal_lahir_siswa');
            $table->string('jenis_kelamin_siswa');
            $table->string('agama_siswa');
            $table->string('no_handphone_siswa');
            $table->string('jurusan');
            $table->string('alamat_siswa');
            $table->string('rt_siswa');
            $table->string('rw_siswa');
            $table->string('kelurahan_siswa');
            $table->string('kecamatan_siswa');
            $table->string('kota_siswa');
            $table->string('provinsi_siswa');
            $table->string('kode_pos_siswa');
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
        Schema::dropIfExists('students');
    }
};
