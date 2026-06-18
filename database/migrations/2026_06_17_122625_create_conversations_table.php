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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('ride_bookings')->cascadeOnDelete();
            $table->foreignId('ride_id')->constrained()->cascadeOnDelete();
            $table->foreignId('driver_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('passenger_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->unique('booking_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
