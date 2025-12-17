<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sales_orders', function (Blueprint $table) {
            // Add missing columns
            if (!Schema::hasColumn('sales_orders', 'company_id')) {
                $table->foreignId('company_id')->nullable()->after('id');
            }

            if (!Schema::hasColumn('sales_orders', 'delivery_date')) {
                $table->date('delivery_date')->nullable()->after('order_date');
            }

            if (!Schema::hasColumn('sales_orders', 'sales_person')) {
                $table->string('sales_person')->nullable()->after('customer_id');
            }

            if (!Schema::hasColumn('sales_orders', 'reference_number')) {
                $table->string('reference_number')->nullable()->after('sales_person');
            }

            if (!Schema::hasColumn('sales_orders', 'shipping_address')) {
                $table->text('shipping_address')->nullable()->after('reference_number');
            }

            if (!Schema::hasColumn('sales_orders', 'billing_address')) {
                $table->text('billing_address')->nullable()->after('shipping_address');
            }

            if (!Schema::hasColumn('sales_orders', 'shipping_method')) {
                $table->string('shipping_method')->nullable()->after('billing_address');
            }

            if (!Schema::hasColumn('sales_orders', 'shipping_charges')) {
                $table->decimal('shipping_charges', 10, 2)->default(0)->after('shipping_method');
            }

            if (!Schema::hasColumn('sales_orders', 'tax_rate')) {
                $table->decimal('tax_rate', 5, 2)->default(0)->after('shipping_charges');
            }

            if (!Schema::hasColumn('sales_orders', 'subtotal')) {
                $table->decimal('subtotal', 12, 2)->default(0)->after('tax_rate');
            }

            if (!Schema::hasColumn('sales_orders', 'tax_amount')) {
                $table->decimal('tax_amount', 12, 2)->default(0)->after('subtotal');
            }

            if (!Schema::hasColumn('sales_orders', 'total_amount')) {
                $table->decimal('total_amount', 12, 2)->default(0)->after('tax_amount');
            }

            if (!Schema::hasColumn('sales_orders', 'terms_conditions')) {
                $table->text('terms_conditions')->nullable()->after('notes');
            }

            if (!Schema::hasColumn('sales_orders', 'created_by')) {
                $table->foreignId('created_by')->nullable()->after('status');
            }

            // Add foreign key constraints if needed
            if (Schema::hasColumn('sales_orders', 'company_id')) {
                $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            }

            if (Schema::hasColumn('sales_orders', 'created_by')) {
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            }
        });
    }

    public function down()
    {
        Schema::table('sales_orders', function (Blueprint $table) {
            // Drop foreign keys first
            $table->dropForeign(['company_id']);
            $table->dropForeign(['created_by']);

            // Drop columns
            $table->dropColumn([
                'company_id',
                'delivery_date',
                'sales_person',
                'reference_number',
                'shipping_address',
                'billing_address',
                'shipping_method',
                'shipping_charges',
                'tax_rate',
                'subtotal',
                'tax_amount',
                'total_amount',
                'terms_conditions',
                'created_by'
            ]);
        });
    }
};
