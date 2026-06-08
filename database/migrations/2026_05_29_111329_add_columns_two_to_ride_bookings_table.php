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
        Schema::table('ride_bookings', function (Blueprint $table) {
            $table->enum('payment_status', [
                'unpaid',
                'paid',
                'failed',
                'refunded'
            ])->default('unpaid')->after('status');
            $table->string('payment_type')->nullable()->after('payment_status');
            $table->string('payment_id')->nullable()->after('payment_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ride_bookings', function (Blueprint $table) {
            $table->dropColumn(['payment_status', 'payment_type', 'payment_id']);
        });
    }
};
