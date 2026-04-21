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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();

            // Relationship
            $table->foreignId('user_id'); // driver

            // Basic Info
            $table->string('vehicle_type'); // car, bike, suv
            $table->string('brand'); // Toyota, Honda
            $table->string('model'); // City, Swift
            $table->year('manufacture_year')->nullable();

            // Registration Details
            $table->string('registration_number')->unique();
            $table->string('color')->nullable();

            // Capacity
            $table->integer('seats')->default(1); // total seats
            $table->integer('available_seats')->default(1); // dynamic for rides

            // Documents (optional but scalable)
            $table->string('rc_file')->nullable(); // registration certificate
            $table->string('insurance_file')->nullable();
            $table->date('insurance_expiry')->nullable();

            $table->string('vehicle_images')->nullable();
            $table->longText('features')->nullable();
            $table->string('fuel_type')->nullable();
            $table->string('rating')->nullable();

            // Status Management
            $table->enum('status', ['active', 'inactive', 'pending', 'blocked'])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
