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
        Schema::create('qcc_internals', function (Blueprint $table) {
            $table->id();
            $table->string('employees_id');
            $table->string('nama_group_qcc_internal');
            $table->string('tema_qcc_internal');
            $table->string('circle_leader_qcc_internal');
            $table->date('tanggal_konvensi_qcc_internal');
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
        Schema::dropIfExists('qcc_internals');
    }
};
