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
            $table->string('rc_number')->nullable()->after('registration_number');
            $table->date('rc_expiry_date')->nullable()->after('rc_number');
            $table->string('insurance_provider')->nullable()->after('rc_expiry_date');
            $table->string('policy_number')->nullable()->after('insurance_provider');
            $table->string('front_image')->nullable()->after('policy_number');
            $table->string('back_image')->nullable()->after('front_image');
            $table->string('side_image')->nullable()->after('back_image');
            $table->string('number_plate_image')->nullable()->after('side_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn([
                'rc_number',
                'rc_expiry_date',
                'insurance_provider',
                'policy_number',
                'front_image',
                'back_image',
                'side_image',
                'number_plate_image',
            ]);
        });
    }
};
