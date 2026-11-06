<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('shipping_destination_id')->nullable()->after('shipping_address');
            $table->string('shipping_destination_label', 255)->nullable()->after('shipping_destination_id');
            $table->string('shipping_courier_name', 100)->nullable()->after('shipping_courier');
            $table->string('shipping_service', 100)->nullable()->after('shipping_courier_name');
            $table->string('shipping_etd', 100)->nullable()->after('shipping_service');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'shipping_destination_id',
                'shipping_destination_label',
                'shipping_courier_name',
                'shipping_service',
                'shipping_etd',
            ]);
        });
    }
};
