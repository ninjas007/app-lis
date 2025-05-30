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
        Schema::create('lab_result_messages', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->unique();
            $table->string('group')->nullable();
            $table->string('code')->nullable();
            $table->string('content')->nullable();
            $table->integer('lab_result_id')->index()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_result_messages');
    }
};
