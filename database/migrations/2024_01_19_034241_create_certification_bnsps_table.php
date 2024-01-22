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
        Schema::create('certification_bnsps', function (Blueprint $table) {
            $table->id();
            $table->integer('employees_id');
            $table->string('jumlah_sertifikat_bnsp');
            $table->string('nomor_sertifikat_bnsp');
            $table->string('jenis_sertifikat_bnsp');
            $table->string('masa_berlaku_sertifikat_bnsp');
            $table->date('tanggal_terbit_bnsp');
            $table->date('sampai_tanggal_bnsp');
            $table->string('lsp_bnsp');
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
        Schema::dropIfExists('certification_bnsps');
    }
};
