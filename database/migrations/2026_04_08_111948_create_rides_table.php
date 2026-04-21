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
        Schema::create('rides', function (Blueprint $table) {
            $table->id();

            // Driver & Vehicle
            $table->foreignId('driver_id');
            $table->foreignId('vehicle_id');

            // Location
            $table->string('source_address');
            $table->string('destination_address');

            $table->decimal('source_lat', 10, 7)->nullable();
            $table->decimal('source_lng', 10, 7)->nullable();
            $table->decimal('destination_lat', 10, 7)->nullable();
            $table->decimal('destination_lng', 10, 7)->nullable();

            // Route (dynamic engine)
            $table->json('route_points')->nullable();

            // 🗓️ Date & Time (separated)
            $table->date('ride_date');
            $table->time('departure_time');

            $table->string('polyline')->nullable();          // Encoded route for quick map rendering
            $table->integer('distance_meters')->nullable();  // Total distance
            $table->integer('duration_seconds')->nullable(); // Travel duration
            $table->text('estimated_reach_time')->nullable();

            // Aminities
            $table->string('pet_allowed')->default('no');
            $table->string('smoking_allowed')->default('no');
            $table->string('instant_booking')->default('no');
            $table->string('max_two_in_back')->default('no');

            // Pricing
            $table->decimal('price_per_seat', 10, 2);

            // Capacity
            $table->integer('total_seats');

            // Status
            $table->enum('status', ['scheduled', 'ongoing', 'completed', 'cancelled'])
                ->default('scheduled');

            $table->timestamps();

            // 🔥 Indexing (important)
            $table->index(['driver_id', 'ride_date']);
            $table->index(['ride_date', 'departure_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rides');
    }
};
