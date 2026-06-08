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
        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('is_rc_verified')->default('pending')->after('rc_file');
            $table->string('is_insurance_verified')->default('pending')->after('insurance_file');
            $table->string('is_number_plate_verified')->default('pending')->after('number_plate_image');
            $table->string('is_side_image_verified')->default('pending')->after('side_image');
            $table->string('is_back_image_verified')->default('pending')->after('back_image');
            $table->string('is_front_image_verified')->default('pending')->after('front_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn([
                'is_rc_verified',
                'is_insurance_verified',
                'is_number_plate_verified',
                'is_side_image_verified',
                'is_back_image_verified',
                'is_front_image_verified'
            ]);
        });
    }
};
