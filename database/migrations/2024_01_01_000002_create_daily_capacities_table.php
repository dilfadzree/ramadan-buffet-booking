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
        Schema::create('daily_capacities', function (Blueprint $table) {
            $table->id();
            $table->date('date')->unique();
            $table->integer('max_capacity')->default(100);
            $table->integer('current_bookings')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_capacities');
    }
};
