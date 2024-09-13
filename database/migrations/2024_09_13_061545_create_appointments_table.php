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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('patient_name');
            $table->string('phone_number');
            $table->string('email');
            $table->date('booking_date');
            $table->string('city');
            $table->string('speciality');
            $table->string('doctor');
            $table->string('gender');
            $table->integer('age');
            $table->text('details')->nullable();
            $table->enum('appointment_status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->timestamps(); // Created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
