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
        Schema::create('answer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')
            ->constrained('question')
            ->onDelete('cascade');
            $table->text('text');
            $table->boolean('is_correct');
            $table->text('explanation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('answer');
    }
};
