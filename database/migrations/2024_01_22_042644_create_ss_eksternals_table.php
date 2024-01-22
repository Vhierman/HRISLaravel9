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
        Schema::create('ss_eksternals', function (Blueprint $table) {
            $table->id();
            $table->string('employees_id');
            $table->string('tema_ss_eksternal');
            $table->date('tanggal_ss_eksternal');
            $table->string('instansi');
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
        Schema::dropIfExists('ss_eksternals');
    }
};
