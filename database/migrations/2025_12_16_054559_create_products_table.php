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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('supplier_id')->nullable()->constrained('companies')->onDelete('set null');
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('set null');

            // Basic information
            $table->string('product_code')->unique();
            $table->string('product_name');
            $table->text('description')->nullable();
            $table->string('short_description')->nullable();
            $table->string('barcode')->unique()->nullable();
            $table->string('sku')->unique()->nullable();
            $table->string('upc')->nullable();
            $table->string('ean')->nullable();

            // Classification
            $table->string('product_type')->default('physical'); // physical, digital, service
            $table->string('unit_of_measure')->default('piece');
            $table->decimal('weight', 10, 3)->nullable(); // in kg
            $table->string('dimensions')->nullable(); // LxWxH in cm
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->string('material')->nullable();

            // Brand & Model
            $table->string('brand_name')->nullable();
            $table->string('model_number')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('country_of_origin')->nullable();

            // Pricing
            $table->decimal('cost_price', 15, 2)->default(0);
            $table->decimal('selling_price', 15, 2)->default(0);
            $table->decimal('wholesale_price', 15, 2)->nullable();
            $table->decimal('retail_price', 15, 2)->nullable();
            $table->decimal('mrp', 15, 2)->nullable(); // Maximum Retail Price
            $table->decimal('discount_percentage', 5, 2)->default(0);
            $table->decimal('discount_amount', 15, 2)->nullable();
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->string('tax_type')->default('inclusive'); // inclusive, exclusive

            // Stock Management
            $table->decimal('stock_quantity', 15, 3)->default(0);
            $table->decimal('available_quantity', 15, 3)->default(0);
            $table->decimal('reserved_quantity', 15, 3)->default(0);
            $table->decimal('min_stock_level', 15, 3)->default(0);
            $table->decimal('max_stock_level', 15, 3)->nullable();
            $table->decimal('reorder_level', 15, 3)->default(0);
            $table->string('stock_status')->default('in_stock'); // in_stock, out_of_stock, low_stock

            // Supplier Information
            $table->string('supplier_code')->nullable();
            $table->string('supplier_product_code')->nullable();
            $table->decimal('supplier_price', 15, 2)->nullable();

            // Product Lifecycle
            $table->date('manufacture_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('shelf_life')->nullable();
            $table->string('warranty_period')->nullable();
            $table->text('warranty_terms')->nullable();

            // Product Attributes
            $table->json('attributes')->nullable(); // For variant attributes
            $table->json('specifications')->nullable();
            $table->json('features')->nullable();

            // Shipping Information
            $table->boolean('requires_shipping')->default(true);
            $table->decimal('shipping_weight', 10, 3)->nullable();
            $table->string('shipping_class')->nullable();
            $table->decimal('shipping_cost', 15, 2)->nullable();

            // Digital Product Fields
            $table->string('digital_file_path')->nullable();
            $table->string('digital_file_name')->nullable();
            $table->integer('download_limit')->nullable();
            $table->integer('download_expiry_days')->nullable();

            // SEO & Marketing
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->json('meta_keywords')->nullable();
            $table->string('slug')->unique();

            // Media
            $table->string('thumbnail_image')->nullable();
            $table->json('gallery_images')->nullable();
            $table->json('document_files')->nullable();

            // Status & Flags
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_new')->default(true);
            $table->boolean('is_best_seller')->default(false);
            $table->boolean('is_on_sale')->default(false);
            $table->boolean('is_digital')->default(false);
            $table->boolean('has_variants')->default(false);
            $table->boolean('is_bundle')->default(false);
            $table->boolean('is_kit')->default(false);

            // Ratings & Reviews
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('total_ratings')->default(0);
            $table->integer('total_reviews')->default(0);

            // Sales Metrics
            $table->integer('total_sold')->default(0);
            $table->integer('total_views')->default(0);
            $table->decimal('total_revenue', 15, 2)->default(0);

            // Audit
            
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['company_id', 'category_id']);
            $table->index(['product_code', 'sku']);
            $table->index('stock_status');
            $table->index(['is_active', 'is_featured']);
            $table->index('created_at');
        });

        // Create product variants table
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('parent_product_id')->nullable()->constrained('products')->onDelete('cascade');
            $table->string('variant_code')->unique();
            $table->string('variant_name');
            $table->json('attributes'); // color: red, size: M, etc.

            // Pricing & Stock for variant
            $table->decimal('price', 15, 2)->default(0);
            $table->decimal('cost_price', 15, 2)->default(0);
            $table->decimal('stock_quantity', 15, 3)->default(0);
            $table->decimal('available_quantity', 15, 3)->default(0);
            $table->string('sku')->unique()->nullable();
            $table->string('barcode')->unique()->nullable();

            // Variant specific images
            $table->string('variant_image')->nullable();

            // Status
            $table->boolean('is_active')->default(true);
            $table->boolean('is_default')->default(false);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['product_id', 'variant_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
        Schema::dropIfExists('products');
    }
};
