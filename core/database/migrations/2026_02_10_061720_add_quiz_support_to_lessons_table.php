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
        Schema::table('lessons', function (Blueprint $table) {
            $table->enum('type', ['video', 'text', 'live_stream', 'zoom_meeting', 'quiz'])->default('video')->change();
            $table->json('quiz_data')->nullable()->after('content');
        });
    }

    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->enum('type', ['video', 'text', 'live_stream', 'zoom_meeting'])->default('video')->change();
            $table->dropColumn('quiz_data');
        });
    }
};
