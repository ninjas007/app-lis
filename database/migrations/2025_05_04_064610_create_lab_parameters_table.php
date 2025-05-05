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
        Schema::create('lab_parameters', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // eg: WBC, HGB
            $table->string('name');          // eg: White Blood Cell
            $table->string('loinc_code')->nullable(); // eg: 6690-2
            $table->string('default_unit')->nullable();
            $table->string('default_ref_range')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_parameters');
    }
};
