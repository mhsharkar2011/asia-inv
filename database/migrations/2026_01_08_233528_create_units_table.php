<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->string('unit_code')->comment('e.g., PCS, KG, L, M');
            $table->string('unit_name');
            $table->string('unit_type')->default('standard')->comment('standard, packing, shipping, etc.');
            $table->decimal('base_unit_multiplier', 15, 6)->default(1)->comment('Multiplier for base unit conversion');
            $table->foreignId('base_unit_id')->nullable()->constrained('units')->onDelete('set null')->comment('Reference to base unit');
            $table->boolean('is_fraction_allowed')->default(false)->comment('Can use fractions of this unit');
            $table->integer('decimal_places')->default(0)->comment('Decimal places for quantity');
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->text('description')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->unique(['company_id', 'unit_code']);
            $table->index('unit_type');
            $table->index('is_active');
            $table->index('created_by');
        });
    }

    public function down()
    {
        Schema::dropIfExists('units');
    }
};
