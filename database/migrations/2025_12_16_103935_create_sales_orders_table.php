<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('customer_id')->constrained('organizations')->onDelete('cascade');
            $table->date('order_date');
            $table->date('delivery_date');
            $table->string('sales_person')->nullable();
            $table->string('reference_number')->nullable();
            $table->text('shipping_address')->nullable();
            $table->text('billing_address')->nullable();
            $table->string('shipping_method')->nullable();
            $table->string('payment_terms')->nullable();
            $table->string('payment_status')->default('pending');
            $table->date('due_date')->nullable();
            $table->string('status')->default('draft');
            $table->decimal('tax_rate', 5, 2)->default(15);
            $table->decimal('shipping_charges', 10, 2)->default(0);
            $table->decimal('adjustment', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->text('terms_conditions')->nullable();
            $table->string('currency')->default('BDT');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');

            // Totals
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('total_discount', 15, 2)->default(0);
            $table->decimal('taxable_amount', 15, 2)->default(0);
            $table->decimal('tax_amount', 15, 2)->default(0);
            $table->decimal('total_amount', 15, 2)->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sales_orders');
    }
};
