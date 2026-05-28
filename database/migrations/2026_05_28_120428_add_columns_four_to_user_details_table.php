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
        Schema::table('user_details', function (Blueprint $table) {
            $table->string('is_dl_verified')->default('pending')->after('driver_license');
            $table->string('is_adhhar_verified')->default('pending')->after('adhhar_card');
            $table->string('is_pan_verified')->default('pending')->after('pan_card');
            $table->string('is_account_verified')->default('pending')->after('bank_account');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_details', function (Blueprint $table) {
            $table->dropColumn([
                'is_dl_verified',
                'is_adhhar_verified',
                'is_pan_verified',
                'is_account_verified'
            ]);
        });
    }
};
