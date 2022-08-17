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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sekolah');
            $table->string('no_telepon_sekolah');
            $table->string('email_sekolah');
            $table->string('nama_guru_pembimbing');
            $table->string('no_handphone_guru_pembimbing');
            $table->string('alamat_sekolah');
            $table->string('rt_sekolah');
            $table->string('rw_sekolah');
            $table->string('kelurahan_sekolah');
            $table->string('kecamatan_sekolah');
            $table->string('kota_sekolah');
            $table->string('provinsi_sekolah');
            $table->string('kode_pos_sekolah');
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
        Schema::dropIfExists('schools');
    }
};
