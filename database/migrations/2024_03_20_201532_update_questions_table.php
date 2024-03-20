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
        Schema::table('questions', function (Blueprint $table) {
            $table->unsignedBigInteger('learning_objective_id')
                ->nullable()
                ->after('category_id');

            $table->foreign('learning_objective_id')
                ->references('id')
                ->on('question_learning_objectives')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign(['learning_objective_id']);
            $table->dropColumn('learning_objective_id');
        });
    }
};
