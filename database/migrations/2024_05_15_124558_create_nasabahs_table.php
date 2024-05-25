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
        Schema::create('nasabahs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('no_hp')->nullable();
            $table->string('titipan')->nullable();
            $table->string('desa')->nullable();
            $table->string('koordinat')->nullable();
            $table->string('koordinat_titipan')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('kelompok')->nullable();
            $table->string('foto_selfy')->nullable();
            $table->string('foto_ktp')->nullable();
            $table->string('foto_rumah')->nullable();
            $table->float('rating')->default(0);
            $table->integer('resort')->default(1);
            $table->integer('checked')->default(0);
            $table->string('status')->default('aktif');
            $table->integer('user_id')->default(1);
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
        Schema::dropIfExists('nasabahs');
    }
};
