<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->string('password');
            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();
            $table->timestamp('two_factor_confirmed_at')->nullable();
            $table->unsignedBigInteger('barangay_id')->nullable(); 
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')
                ->references('role_id')
                ->on('roles')
                ->onDelete('cascade');
            $table->foreign('barangay_id') 
                ->references('id')
                ->on('barangays')
                ->onDelete('set null'); 
            $table->string('phone_number', 20)->nullable();
            $table->rememberToken();
            $table->timestamps();
        
            $table->index('firstname');
            $table->index('lastname');
            $table->index('phone_number');
            $table->index('barangay_id');
            $table->index('role_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};


