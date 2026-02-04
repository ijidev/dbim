<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('financial_records', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->enum('type', ['income', 'expense']);
            $blueprint->string('category');
            $blueprint->decimal('amount', 15, 2);
            $blueprint->text('description')->nullable();
            $blueprint->date('entry_date');
            $blueprint->foreignId('recorded_by')->constrained('users')->onDelete('cascade');
            $blueprint->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financial_records');
    }
};
