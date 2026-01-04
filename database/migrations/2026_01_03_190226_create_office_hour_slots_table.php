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
        Schema::create('office_hour_slots', function (Blueprint $table) {
        $table->id();

        // teacher who owns this slot
        $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');

        $table->date('slot_date');
        $table->string('slot_time'); // keep string (same style as you used for transport time)
        $table->string('location')->nullable();
        $table->integer('capacity')->default(1); // default 1 booking

        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('office_hour_slots');
    }
};
