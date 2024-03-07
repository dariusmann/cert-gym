<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('question_run_questions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('question_run_id')
                ->constrained('question_runs')
                ->onDelete('cascade');

            $table->foreignId('question_id')
                ->constrained('questions')
                ->onDelete('cascade');

            $table->unsignedBigInteger('attempt_id')->nullable();

            $table->foreign('attempt_id')
                ->references('id')
                ->on('question_attempts')
                ->onDelete('cascade');

            $table->integer('order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_run_questions');
    }
};