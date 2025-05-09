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
        Schema::create('lab_result_details', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->unique();
            $table->foreignId('lab_result_id')->constrained()->onDelete('cascade');
            $table->foreignId('lab_parameter_id')->constrained()->onDelete('cascade');
            $table->string('result')->nullable();
            $table->string('unit')->nullable();          // disimpan terpisah dari default
            $table->string('reference_range')->nullable();     // bisa berbeda tergantung usia, jenis kelamin
            $table->string('flag')->nullable(); // normal, high, low
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_result_details');
    }
};
