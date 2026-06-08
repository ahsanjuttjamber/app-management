<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up()
{
    Schema::table('customer_devices', function (Blueprint $table) {
        if (!Schema::hasColumn('customer_devices', 'last_latitude')) {
            $table->string('last_latitude')->nullable();
        }
        if (!Schema::hasColumn('customer_devices', 'last_longitude')) {
            $table->string('last_longitude')->nullable();
        }
        if (!Schema::hasColumn('customer_devices', 'last_location_at')) {
            $table->timestamp('last_location_at')->nullable();
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_devices', function (Blueprint $table) {
            //
        });
    }
};
