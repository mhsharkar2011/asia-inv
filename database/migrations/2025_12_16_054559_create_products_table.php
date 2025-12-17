<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('product_code')->unique();
            $table->string('product_name');
            $table->text('description')->nullable();
            $table->string('unit_of_measure')->nullable();
            $table->decimal('purchase_price', 10, 2)->default(0);
            $table->decimal('selling_price', 10, 2)->default(0);
            $table->decimal('mrp', 10, 2)->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->integer('reorder_level')->default(10);
            $table->string('hs_code')->nullable();
            $table->decimal('ait_rate', 5, 2)->default(0);
             $table->decimal('tax_rate', 5, 2)->nullable();
            $table->integer('min_stock')->default(0);
            $table->integer('max_stock')->nullable();
            $table->boolean('track_batch')->default(false);
            $table->boolean('track_expiry')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
