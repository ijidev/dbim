<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('lessons')) {
            Schema::create('lessons', function (Blueprint $table) {
                $table->id();
                $table->foreignId('module_id')->constrained()->cascadeOnDelete();
                $table->string('title');
                $table->enum('type', ['video', 'text', 'live_stream', 'zoom_meeting'])->default('video');
                $table->string('video_url')->nullable(); // For YouTube/Vimeo/MP4
                $table->text('content')->nullable(); // For text lessons
                $table->string('live_url')->nullable(); // For Zoom/Jitsi
                $table->boolean('is_free')->default(false); // Previewable?
                $table->integer('order')->default(0);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
