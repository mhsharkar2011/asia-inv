<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('warehouse_id')->constrained('warehouses')->onDelete('cascade');
            $table->string('batch_number')->nullable();
            $table->date('expiry_date')->nullable();
            $table->decimal('quantity_available', 15, 2)->default(0);
            $table->decimal('quantity_reserved', 15, 2)->default(0);
            $table->decimal('average_purchase_price', 15, 2)->default(0);
            $table->date('last_purchase_date')->nullable();
            $table->date('last_sale_date')->nullable();
            $table->timestamps();

            $table->unique(['product_id', 'warehouse_id', 'batch_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
