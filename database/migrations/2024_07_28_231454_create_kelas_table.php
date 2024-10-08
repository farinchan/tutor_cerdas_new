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
        Schema::create('kelas', function (Blueprint $table) {
            $table->string('kode_kelas', 10)->primary();
            $table->string('nama_kelas', 50);
            $table->string('tingkat', 10);
            $table->string('jurusan', 50);
            $table->string('kode_mk', 30); // Add kode_mk column
            $table->foreign('kode_mk')->references('kode_mk')->on('matakuliah')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('nidn'); // Add nidn column
            $table->foreign('nidn')->references('nidn')->on('dosen')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
