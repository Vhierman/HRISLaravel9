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
        Schema::create('inventory_cars', function (Blueprint $table) {
            $table->id();
            $table->integer('employees_id');
            $table->string('merk_mobil');
            $table->string('type_mobil');
            $table->string('nomor_polisi');
            $table->string('warna_mobil');
            $table->string('nomor_rangka_mobil');
            $table->string('nomor_mesin_mobil');
            $table->date('tanggal_akhir_pajak_mobil');
            $table->date('tanggal_akhir_plat_mobil');
            $table->date('tanggal_penyerahan_mobil');
            $table->string('foto_stnk_mobil');
            $table->string('foto_mobil');
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
        Schema::dropIfExists('inventory_cars');
    }
};
