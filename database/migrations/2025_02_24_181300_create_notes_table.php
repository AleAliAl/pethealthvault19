<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id('NoteID');
            $table->unsignedBigInteger('PetID');  
            $table->text('NoteContent'); 
            $table->timestamps();
        
            $table->foreign('PetID')->references('PetID')->on('pets')->onDelete('cascade');

            $table->index('PetID');
        });
        
    }

   
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
