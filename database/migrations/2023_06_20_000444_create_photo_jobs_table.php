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
            $table->string('photo_type');
            $table->string('photo_contents');
            $table->enum('photo_format', ['portrait', 'landscape', 'both'])->default('both');
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
