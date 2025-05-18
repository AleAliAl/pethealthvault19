<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('vaccinations', function (Blueprint $table) {
            $table->id('VaccinationID');
            $table->unsignedBigInteger('PetID');  
            $table->date('RecordDate');  
            $table->string('VaccinationName', 100);  
            $table->date('NextDueDate')->nullable();  
            $table->string('Veterinarian', 100);  
            $table->timestamps();
        
            $table->foreign('PetID')->references('PetID')->on('pets')->onDelete('cascade');
        });
        
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccinations');
    }
};
