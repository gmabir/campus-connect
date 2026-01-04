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
        Schema::create('event_photos', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')->constrained()->onDelete('cascade');

        // optional: link to events
        $table->foreignId('event_id')->nullable()->constrained('events')->nullOnDelete();

        $table->string('caption')->nullable();

        $table->string('image_path');
        $table->string('original_name');
        $table->string('mime_type')->nullable();
        $table->unsignedBigInteger('file_size')->nullable();

        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_photos');
    }
};
