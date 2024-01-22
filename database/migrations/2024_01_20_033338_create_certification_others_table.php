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
        Schema::create('certification_others', function (Blueprint $table) {
            $table->id();
            $table->integer('employees_id');
            $table->string('jumlah_sertifikat_lain');
            $table->string('nomor_sertifikat_lain');
            $table->string('jenis_sertifikat_lain');
            $table->date('tanggal_terbit_lain');
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
        Schema::dropIfExists('certification_others');
    }
};
