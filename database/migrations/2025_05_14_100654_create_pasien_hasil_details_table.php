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
        Schema::create('pasien_hasil_details', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->unique();
            $table->integer('patient_id');
            $table->integer('hasil_id');
            $table->text('diagnosa')->nullable();
            $table->text('catatan')->nullable();
            $table->string('dokter_pengirim')->nullable();
            $table->string('dokter_penanggung_jawab')->nullable();
            $table->string('ruangan_poli')->nullable();
            $table->string('petugas')->nullable();
            $table->string('verifikasi')->nullable();
            $table->string('status')->nullable();
            $table->string('jenis_layanan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasien_hasil_details');
    }
};
