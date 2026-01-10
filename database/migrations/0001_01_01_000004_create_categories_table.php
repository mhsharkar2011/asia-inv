<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->string('category_code')->unique();
            $table->string('category_name');
            $table->foreignId('parent_category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->text('description')->nullable();
            $table->decimal('tax_rate_applicable', 5, 2)->nullable();
            $table->timestamps();

            $table->index(['company_id', 'category_code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
