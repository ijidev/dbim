<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('annotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('chapter_id');
            $table->string('annotation_id')->nullable(); // client-side ID (e.g. ann-1709312000000)
            $table->enum('type', ['highlight', 'note'])->default('highlight');
            $table->text('text'); // the highlighted text
            $table->text('note')->nullable(); // user's personal note
            $table->string('color')->default('hl-gold');
            $table->timestamps();

            $table->foreign('chapter_id')->references('id')->on('book_chapters')->onDelete('cascade');
            $table->index(['user_id', 'chapter_id']);
            $table->index(['user_id', 'book_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('annotations');
    }
};
