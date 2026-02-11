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
        Schema::table('meetings', function (Blueprint $table) {
            $table->string('type')->default('scheduled')->change();
            $table->enum('visibility', ['public', 'private'])->default('public')->after('type');
            $table->decimal('price', 10, 2)->default(0.00)->after('scheduled_at');
            $table->integer('max_participants')->default(1)->after('price');
            $table->json('allowed_student_ids')->nullable()->after('max_participants');
        });
    }

    public function down(): void
    {
        Schema::table('meetings', function (Blueprint $table) {
            $table->dropColumn(['visibility', 'price', 'max_participants', 'allowed_student_ids']);
        });
    }
};
