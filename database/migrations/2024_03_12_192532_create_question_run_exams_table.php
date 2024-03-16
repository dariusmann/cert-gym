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
        Schema::create('question_run_exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_run_id')
                ->constrained('question_runs')
                ->onDelete('cascade');
            $table->dateTime('started_at');
            $table->boolean('completed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_run_exams');
    }
};
