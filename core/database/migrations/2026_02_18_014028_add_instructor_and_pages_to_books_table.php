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
        Schema::table('books', function (Blueprint $table) {
            if (!Schema::hasColumn('books', 'instructor_id')) {
                $table->foreignId('instructor_id')->nullable()->constrained('users')->onDelete('cascade');
            }
            if (!Schema::hasColumn('books', 'category')) {
                $table->string('category')->nullable();
            }
            if (!Schema::hasColumn('books', 'pages')) {
                $table->integer('pages')->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            if (Schema::hasColumn('books', 'instructor_id')) {
                $table->dropForeign(['instructor_id']);
                $table->dropColumn('instructor_id');
            }
            if (Schema::hasColumn('books', 'category')) {
                $table->dropColumn('category');
            }
            if (Schema::hasColumn('books', 'pages')) {
                $table->dropColumn('pages');
            }
        });
    }
};
