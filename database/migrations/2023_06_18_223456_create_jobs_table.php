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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('photo_type');
            $table->string('photo_contents');
            $table->enum('photo_style', ['portrait', 'landscape'])->default('landscape');
            $table->string('text_topic');
            $table->string('text_keywords');
            $table->integer('text_length');
            $table->string('text_tone');
            $table->string('text_cta'); // Call to action / desired goal
            $table->string('text_language');
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
        Schema::dropIfExists('jobs');
    }
};
