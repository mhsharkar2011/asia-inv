<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('organizations')->onDelete('cascade');
            $table->string('branch_code')->unique()->comment('Branch identifier e.g., BRN001');
            $table->string('branch_name');
            $table->string('branch_type')->default('retail')->comment('retail, warehouse, office, factory, etc.');
            $table->string('contact_person')->nullable();
            $table->string('branch_email')->nullable();
            $table->string('branch_phone')->nullable();
            $table->string('branch_mobile_phone')->nullable();
            $table->string('branch_address')->nullable();
            $table->string('postal_area')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('country')->default('Bangladesh');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->time('opening_time')->default('09:00:00');
            $table->time('closing_time')->default('18:00:00');
            $table->string('working_days')->default('Monday-Friday')->comment('e.g., Monday-Friday, Sunday-Thursday');
            $table->integer('staff_count')->default(0);
            $table->decimal('area_sqft', 10, 2)->nullable()->comment('Branch area in square feet');
            $table->boolean('is_head_office')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('has_warehouse')->default(false);
            $table->boolean('has_showroom')->default(false);
            $table->text('description')->nullable();
            $table->json('additional_info')->nullable()->comment('JSON for custom fields');
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            // $table->index(['company_id', 'is_active']);
            $table->index('branch_code');
            $table->index('city');
            $table->index('branch_type');
            $table->index('is_head_office');
        });
    }

    public function down()
    {
        Schema::dropIfExists('branches');
    }
};
