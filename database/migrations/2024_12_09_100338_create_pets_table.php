<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id('PetID');
            $table->unsignedBigInteger('UserID');
            $table->string('Name', 50);
            $table->enum('Species', ['Canine', 'Feline']);
            $table->string('Breed', 50)->nullable();
            $table->integer('AgeYears')->nullable()->comment('Age in years');
            $table->integer('AgeMonths')->nullable()->comment('Age in months');
            $table->enum('Gender', ['Male', 'Female']);
            $table->string('Image')->nullable();

            $table->foreign('UserID')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
