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
        Schema::create('inventory_motorcycles', function (Blueprint $table) {
            $table->id();
            $table->integer('employees_id');
            $table->string('merk_motor');
            $table->string('type_motor');
            $table->string('nomor_polisi');
            $table->string('warna_motor');
            $table->string('nomor_rangka_motor');
            $table->string('nomor_mesin_motor');
            $table->date('tanggal_akhir_pajak_motor');
            $table->date('tanggal_akhir_plat_motor');
            $table->date('tanggal_penyerahan_motor');
            $table->string('foto_stnk_motor');
            $table->string('foto_motor');
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
        Schema::dropIfExists('inventory_motorcycles');
    }
};
