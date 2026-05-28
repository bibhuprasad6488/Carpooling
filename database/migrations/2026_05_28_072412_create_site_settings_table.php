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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_title')->nullable();
            $table->string('site_logo')->nullable();
            $table->string('footer_logo')->nullable();
            $table->string('footer_logo_one')->nullable();
            $table->string('footer_logo_two')->nullable();
            $table->string('favicon')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('alt_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('alt_phone')->nullable();
            $table->string('call_wp_number')->nullable();
            $table->longText('wp_message')->nullable();
            $table->string('copyright')->nullable();
            $table->longText('site_desc')->nullable();
            $table->longText('site_map_key')->nullable();
            $table->longText('address')->nullable();
            $table->longText('site_meta_desc')->nullable();
            $table->longText('site_meta_key')->nullable();
            $table->string('smtp_host')->nullable();
            $table->string('smtp_port')->nullable();
            $table->string('smtp_username')->nullable();
            $table->string('smtp_password')->nullable();
            $table->string('smtp_from_name')->nullable();
            $table->string('smtp_from_email')->nullable();
            $table->enum('partner_show', [1, 0])->default(1);
            $table->string('cta_title')->nullable();
            $table->string('cta_sub_title')->nullable();
            $table->longText('footer_text_one')->nullable();
            $table->longText('footer_text_two')->nullable();
            $table->longText('social_links')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
