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
        Schema::create('attendances_pkls', function (Blueprint $table) {
            $table->id();
            $table->string('students_id');
            $table->date('tanggal_absen');
            $table->string('keterangan_absen');
            $table->string('lama_absen');
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
        Schema::dropIfExists('attendances_pkls');
    }
};
