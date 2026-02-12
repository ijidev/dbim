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
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quiz_id');
            $table->foreign('quiz_id')->references('id')->on('quizzes')->onDelete('cascade');
            $table->enum('type', ['multiple_choice', 'open_ended', 'true_false'])->default('multiple_choice');
            $table->text('question_text');
            $table->json('options')->nullable()->comment('For multiple choice: array of answer options');
            $table->text('correct_answer')->nullable()->comment('For multiple choice: correct option index/text; For open-ended: sample answer');
            $table->integer('points')->default(1);
            $table->integer('order')->default(0);
            $table->boolean('is_required')->default(true);
            $table->text('explanation')->nullable()->comment('Shown after answering');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_questions');
    }
};
