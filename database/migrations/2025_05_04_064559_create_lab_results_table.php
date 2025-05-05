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
        Schema::create('lab_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->string('lab_number')->nullable(); // optional
            $table->string('doctor')->nullable();
            $table->string('department')->nullable();
            $table->dateTime('sample_taken_at')->nullable(); // dari OBR
            $table->dateTime('result_at')->nullable();       // dari OBR
            $table->string('test_type')->nullable();         // OBR test type (CBC, dll)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_results');
    }
};
