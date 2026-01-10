<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->enum('type', ['company', 'customer', 'supplier'])->default('company');
            $table->enum('sub_type', ['retail', 'wholesale', 'corporate', 'local', 'international'])->nullable();

            // Contact Information
            $table->string('contact_person')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();

            // Address Information
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('country')->default('Bangladesh');
            $table->string('postal_code')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            // Business Information
            $table->string('tin')->nullable()->comment('Tax Identification Number');
            $table->string('bin')->nullable()->comment('Business Identification Number');
            $table->string('trade_license')->nullable();
            $table->string('website')->nullable();
            $table->string('logo')->nullable();
            $table->string('currency')->default('BDT');
            $table->string('fiscal_year_start')->default('04-01-1000')->comment('DD-MM-YYYY format');

            // Status & Settings
            $table->boolean('is_active')->default(true);
            $table->string('timezone')->default('Asia/Dhaka');
            $table->string('language')->default('en');

            // Financial Information (for customers)
            $table->decimal('credit_limit', 15, 2)->default(0);
            $table->decimal('outstanding_balance', 15, 2)->default(0);

            // Financial Information (for suppliers)
            $table->string('payment_terms')->nullable();
            $table->decimal('advance_payment_percentage', 5, 2)->default(0);

            // Additional Fields
            $table->text('notes')->nullable();
            $table->text('description')->nullable();

            // Timestamps
            $table->timestamps();
            $table->softDeletes();

            // Optimized Indexes
            $table->index(['type', 'is_active']);
            $table->index(['code', 'name']);
            $table->index(['city', 'country']);
            $table->index('email');
            $table->index('phone');
        });

        // Create pivot table for company-customer-supplier relationships
        Schema::create('company_relationships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->foreignId('related_id')->constrained('companies')->onDelete('cascade');
            $table->enum('relationship_type', ['customer', 'supplier', 'branch', 'parent']);
            $table->json('settings')->nullable()->comment('Relationship specific settings');
            $table->timestamps();

            $table->unique(['company_id', 'related_id', 'relationship_type'], 'org_rel_unique');
            $table->index(['company_id', 'relationship_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_relationships');
        Schema::dropIfExists('companies');
    }
};
