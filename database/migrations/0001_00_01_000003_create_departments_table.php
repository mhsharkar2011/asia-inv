<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('departments')->onDelete('set null');
            $table->string('code')->unique()->comment('Department code e.g., DEPT001');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('staff_count')->default(0);
            $table->decimal('budget', 15, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['is_active', 'sort_order']);
            $table->index('code');
        });
    }

    public function down()
    {
        Schema::dropIfExists('departments');
    }
};
