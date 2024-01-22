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
        Schema::create('qcc_eksternals', function (Blueprint $table) {
            $table->id();
            $table->string('employees_id');
            $table->string('nama_group_qcc_eksternal');
            $table->string('tema_qcc_eksternal');
            $table->string('circle_leader_qcc_eksternal');
            $table->date('tanggal_konvensi_qcc_eksternal');
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
        Schema::dropIfExists('qcc_eksternals');
    }
};
