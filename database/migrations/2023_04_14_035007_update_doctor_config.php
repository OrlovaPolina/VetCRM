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
        Schema::dropIfExists('doctor_config');
        Schema::create('doctor_config', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id');
            $table->foreign('doctor_id')->references('id')->on('users');
            $table->string('name');
            $table->longText('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};