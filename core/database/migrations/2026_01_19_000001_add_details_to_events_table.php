<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('end_time')->nullable();
            $table->string('end_date')->nullable();
            $table->enum('recurrence', ['none', 'daily', 'weekly', 'monthly', 'yearly'])->default('none');
            $table->enum('type', ['program', 'service', 'activity'])->default('program');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['end_time', 'end_date', 'recurrence', 'type']);
        });
    }
};
