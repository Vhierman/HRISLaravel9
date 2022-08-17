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
        Schema::create('history_positions', function (Blueprint $table) {
            $table->id();
            $table->integer('employees_id');
            $table->integer('companies_id_history');
            $table->integer('areas_id_history');
            $table->integer('divisions_id_history');
            $table->integer('positions_id_history');
            $table->date('tanggal_mutasi');
            $table->string('file_surat_mutasi');
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
        Schema::dropIfExists('history_positions');
    }
};
