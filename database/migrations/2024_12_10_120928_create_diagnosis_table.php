<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diagnosis', function (Blueprint $table) {
            $table->id('DiagnosisID');
            $table->unsignedBigInteger('PetID');  
            $table->date('RecordDate');  
            $table->string('Diagnosis');  
            $table->unsignedBigInteger('MedicationID')->nullable();  
            $table->string('Veterinarian', 100);
            $table->timestamps();
        
            $table->foreign('PetID')->references('PetID')->on('pets')->onDelete('cascade');
            $table->foreign('MedicationID')->references('MedicationID')->on('medications')->onDelete('set null');

            $table->index('PetID');
            $table->index('MedicationID');
            $table->index('RecordDate');
            $table->index('Veterinarian');
            $table->index('Diagnosis');
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('diagnosis');
    }
};





