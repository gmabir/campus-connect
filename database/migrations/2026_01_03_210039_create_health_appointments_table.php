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
        Schema::create('health_appointments', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // student/user requesting

        $table->date('appointment_date');
        $table->string('appointment_time'); // keep string style

        $table->string('reason')->nullable();
        $table->string('status')->default('pending'); // pending|approved|rejected|completed

        $table->string('doctor_note')->nullable(); // medical staff note

        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_appointments');
    }
};
