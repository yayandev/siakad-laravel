<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_siswa');
            $table->unsignedBigInteger('id_tahun_akademik');
            $table->unsignedBigInteger('id_mapel');
            $table->unsignedBigInteger('id_semester');
            $table->foreign('id_siswa')->references('id')->on('siswas')->onDelete('cascade');
            $table->foreign('id_tahun_akademik')->references('id')->on('tahun_akademiks')->onDelete('cascade');
            $table->foreign('id_mapel')->references('id')->on('mapels')->onDelete('cascade');
            $table->foreign('id_semester')->references('id')->on('semesters')->onDelete('cascade');
            $table->integer('hadir')->nullable();
            $table->integer('sakit')->nullable();
            $table->integer('alpa')->nullable();
            $table->integer('ijin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
