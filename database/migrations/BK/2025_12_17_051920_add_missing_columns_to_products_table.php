<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Add the missing columns
            $table->string('unit_of_measure', 20)->nullable()->after('unit');
            $table->decimal('purchase_price', 10, 2)->nullable()->after('cost_price');
            $table->decimal('mrp', 10, 2)->nullable()->after('selling_price');
            $table->string('hsn_sac_code', 10)->nullable()->after('hs_code');
            $table->decimal('tax_rate', 5, 2)->nullable()->after('ait_rate');
            $table->integer('min_stock')->default(0);
            $table->integer('max_stock')->nullable();
            $table->boolean('track_batch')->default(false);
            $table->boolean('track_expiry')->default(false);
            $table->boolean('is_active')->default(true);
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'unit_of_measure',
                'purchase_price',
                'mrp',
                'hsn_sac_code',
                'tax_rate',
                'min_stock',
                'max_stock',
                'track_batch',
                'track_expiry',
                'is_active'
            ]);
        });
    }
};
