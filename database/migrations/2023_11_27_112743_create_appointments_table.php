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
            $table->id();
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('patient_id');
            $table->string('name');
            $table->string('institution');
            $table->string('department');
            $table->dateTime('appointment_start_time');
            $table->dateTime('appointment_end_time');
            $table->text('notes');
            $table->text('description');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable;
            $table->timestamps();

            $table->foreign('doctor_id')->references('id')->on('users');
            $table->foreign('patient_id')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
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
