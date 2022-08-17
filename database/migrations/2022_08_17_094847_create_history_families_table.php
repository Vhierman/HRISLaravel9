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
        Schema::create('history_families', function (Blueprint $table) {
            $table->id();
            $table->integer('employees_id');
            $table->string('hubungan_keluarga');
            $table->string('nik_history_keluarga');
            $table->string('nomor_bpjs_kesehatan_history_keluarga');
            $table->string('nama_history_keluarga');
            $table->string('jenis_kelamin_history_keluarga');
            $table->string('tempat_lahir_history_keluarga');
            $table->date('tanggal_lahir_history_keluarga');
            $table->string('golongan_darah_history_keluarga');
            $table->text('dokumen_history_keluarga');
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
        Schema::dropIfExists('history_families');
    }
};
