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
        Schema::create('certification_ministrys', function (Blueprint $table) {
            $table->id();
            $table->integer('employees_id');
            $table->string('jumlah_sertifikat_kementrian');
            $table->string('nomor_sertifikat_kementrian');
            $table->string('jenis_sertifikat_kementrian');
            $table->string('masa_berlaku_sertifikat_kementrian');
            $table->date('tanggal_terbit_kementrian');
            $table->date('sampai_tanggal_kementrian');
            $table->string('lsp_kementrian');
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
        Schema::dropIfExists('certification_ministrys');
    }
};
