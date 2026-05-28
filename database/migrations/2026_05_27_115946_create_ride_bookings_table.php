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
        Schema::create('ride_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique();
            $table->foreignId('ride_id');
            $table->foreignId('passenger_id');
            $table->integer('seats');
            $table->string('ride_source');
            $table->string('ride_destination');
            $table->decimal('ride_source_lat', 10, 7)->nullable();
            $table->decimal('ride_source_lng', 10, 7)->nullable();
            $table->decimal('ride_destination_lat', 10, 7)->nullable();
            $table->decimal('ride_destination_lng', 10, 7)->nullable();
            $table->date('ride_date')->nullable();
            $table->time('ride_time')->nullable();
            $table->decimal('price_per_seat', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->enum('status', [
                'pending',
                'accepted',
                'rejected',
                'payment_pending',
                'confirmed',
                'cancelled',
                'completed'
            ])->default('pending');

            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->text('cancel_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ride_bookings');
    }
};
