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
//            $table->string('mood');
            $table->string('orientation')->nullable()->default(null);
            $table->string('elements');
            $table->string('style')->nullable()->default(null);
//            $table->string('setting')->nullable()->default(null);
            $table->string('size')->nullable()->default(null);
            $table->string('color')->nullable()->default(null);
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
