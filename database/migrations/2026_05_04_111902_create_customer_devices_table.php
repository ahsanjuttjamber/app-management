<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_devices', function (Blueprint $table) {
            $table->id();
            $table->string('device_id')->unique();
            $table->string('customer_name');
            $table->string('phone_number');
            $table->enum('status', ['active', 'soft_block', 'full_lock', 'cleared'])->default('active');
            $table->enum('lock_type', ['soft', 'full'])->default('soft');
            $table->boolean('is_blocked')->default(false);
            $table->boolean('is_fully_paid')->default(false);
            $table->string('last_latitude')->nullable();
            $table->string('last_longitude')->nullable();
            $table->timestamp('last_location_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_devices');
    }
};
