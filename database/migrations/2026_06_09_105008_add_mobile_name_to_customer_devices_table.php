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
        if (!Schema::hasColumn('customer_devices', 'mobile_name')) {
            $table->string('mobile_name')->nullable();
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
