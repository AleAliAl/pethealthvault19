<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medications', function (Blueprint $table) {
            $table->id('MedicationID');
            $table->string('ProductName'); 
            $table->string('Dosage');
            $table->string('Frequency');
            $table->integer('DurationDays')->nullable();
            $table->decimal('Price', 8, 2)->nullable(); // Added Price
            $table->string('Type')->nullable(); // Added Type
            $table->integer('StockQuantity')->default(0); // Added Stock Quantity
            $table->date('ExpirationDate')->nullable(); // Added Expiration Date
            $table->timestamps();

            $table->index('ProductName');
            $table->index('Type');
            $table->index('ExpirationDate');
            $table->index('StockQuantity');
        });       
    }

    public function down(): void
    {
        Schema::dropIfExists('medications');
    }
};
