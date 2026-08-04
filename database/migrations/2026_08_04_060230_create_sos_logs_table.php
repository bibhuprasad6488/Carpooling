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
        Schema::create('sos_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('ride_id');
            $table->integer('user_id');
            $table->enum('user_type', ['passenger', 'driver'])->default('passenger');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->enum('status', ['triggered', 'acknowledged', 'resolved'])->default('triggered');
            $table->integer('resolved_by')->nullable();
            $table->text('resolution_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sos_logs');
    }
};
