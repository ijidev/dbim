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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->string('image');
            $table->string('location');
            $table->string('time');
            $table->string('date');
            $table->enum('day',['Monday','Tusday','Wednesday','Thursday','Friday','Satuday','Sunday'])->default('Monday');
            $table->enum('month',['Jan','Feb','March','April','May','Jun','July','Augt','Sep','Oct' , 'Nov', 'Dec' ]);
            $table->string('year');
            $table->enum('status',['comming','passed',])->default('comming');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
