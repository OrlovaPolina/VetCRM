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
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('name',255);
            $table->unsignedBigInteger('breed_id');
            $table->foreign('breed_id')->references('id')->on('breed');
            $table->unsignedBigInteger('species_id');
            $table->foreign('species_id')->references('id')->on('species');
            $table->decimal('age');
            $table->enum('passport',[0,1]);
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
