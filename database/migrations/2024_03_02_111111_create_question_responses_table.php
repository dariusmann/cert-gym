<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('question_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attempt_id')
                ->constrained('question_attempts')
                ->onDelete('cascade');

            $table->unsignedBigInteger('answer_id')->nullable();

            $table->foreign('answer_id')
                ->references('id')
                ->on('question_answers')
                ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('question_responses');
    }
};
