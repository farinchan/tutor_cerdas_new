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
        Schema::create('pretest_answer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pretest_session_id')->constrained('pretest_session')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('pretest_question_id')->constrained('pretest_question')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('pretest_choice_id')->constrained('pretest_choice')->onDelete('cascade')->onUpdate('cascade');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pretest_answers');
    }
};
