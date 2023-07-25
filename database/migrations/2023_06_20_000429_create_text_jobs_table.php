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
        Schema::create('text_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('name');
            $table->string('subject');
            $table->integer('word_amount');
            $table->enum('text_tone', ['Formal', 'Informal', 'Neutral'])->default('Neutral');
            $table->enum('audience_intent', ['Informational', 'Commercial', 'Transactional', 'Instructional', 'Entertainment'])->default('Informational');
            $table->string('primary_keyword');
            $table->json('secondary_keywords')->nullable();
            $table->json('frequently_asked_questions')->nullable();
            $table->enum('call_to_action', ['buy_now', 'sign_up', 'learn_more']);
            $table->string('text_language')->default('English');
            $table->longText('generated_seo_text')->nullable();
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
        Schema::dropIfExists('text_jobs');
    }
};
