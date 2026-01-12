<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');

            // Basic information
            $table->string('code')->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // Contact information
            $table->string('logo')->nullable();
            $table->string('website')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();

            // Company details
            $table->string('country_of_origin')->nullable();
            $table->integer('established_year')->nullable();

            // Status flags
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);

            // SEO fields
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->json('meta_keywords')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id','code']);

            // Indexes
            $table->index(['company_id', 'code']);
            $table->index(['company_id', 'name']);
            $table->index('slug');
            $table->index('is_active');
            $table->index('is_featured');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
