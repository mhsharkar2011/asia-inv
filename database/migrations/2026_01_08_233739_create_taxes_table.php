<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('taxes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->string('tax_code')->comment('e.g., GST, VAT, TAX01');
            $table->string('tax_name');
            $table->decimal('tax_rate', 8, 4)->default(0)->comment('Tax rate in percentage');
            $table->string('tax_type')->default('percentage')->comment('percentage, fixed, compound');
            $table->boolean('is_compound')->default(false)->comment('Is this a compound tax?');
            $table->boolean('is_active')->default(true);
            $table->string('applicable_on')->default('sales')->comment('sales, purchase, both');
            $table->date('effective_from')->nullable()->comment('Tax effective start date');
            $table->date('effective_to')->nullable()->comment('Tax effective end date');
            $table->text('description')->nullable();
            $table->json('calculation_method')->nullable()->comment('JSON for complex tax calculations');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->unique(['company_id', 'tax_code']);
            $table->index('tax_type');
            $table->index('applicable_on');
            $table->index('is_active');
            $table->index(['effective_from', 'effective_to']);
            $table->index('created_by');
        });
    }

    public function down()
    {
        Schema::dropIfExists('taxes');
    }
};
