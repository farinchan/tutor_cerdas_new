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
        Schema::create('pretest_question', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pretest_id')->constrained('pretest')->onDelete('cascade')->onUpdate('cascade');
            $table->longText('question');
            $table->float('score');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pretest_questions');
    }
};
