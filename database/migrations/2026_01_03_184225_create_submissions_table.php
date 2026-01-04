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
       Schema::create('submissions', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')->constrained()->onDelete('cascade');

        $table->string('type'); // thesis | internship | project
        $table->string('title');
        $table->text('description')->nullable();

        $table->string('department')->nullable();
        $table->string('batch')->nullable();
        $table->string('supervisor_name')->nullable();

        $table->string('file_path');
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
        Schema::dropIfExists('submissions');
    }
};
