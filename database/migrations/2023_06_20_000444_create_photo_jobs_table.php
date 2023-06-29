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
        Schema::create('photo_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('subject');
            $table->string('mood');
            $table->enum('orientation', ['portrait', 'landscape', 'both'])->default('both');
            $table->string('elements');
            $table->enum('style', ['minimalist', 'detailed', 'both'])->default('both');
            $table->enum('setting', ['vintage', 'modern', 'both'])->default('both');
            $table->string('purpose');
            $table->json('pexels_response')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photo_jobs');
    }
};
