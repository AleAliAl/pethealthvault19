<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id('AppointmentID');
            $table->unsignedBigInteger('PetID')->nullable(); 
            $table->string('FirstName'); 
            $table->string('LastName'); 
            $table->string('OwnerEmail'); 
            $table->date('AppointmentDate');
            $table->time('AppointmentTime');
            $table->text('Description')->nullable();
            $table->enum('Status', ['Pending', 'Approved', 'Declined', 'Completed', 'Canceled'])->default('Pending');
            $table->timestamps();
            $table->foreign('PetID')->references('PetID')->on('pets')->onDelete('cascade');

            $table->index('PetID');
            $table->index('AppointmentDate');
            $table->index('Status');
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
