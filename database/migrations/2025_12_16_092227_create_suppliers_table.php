<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->string('supplier_code')->unique();
            $table->string('supplier_name');
            $table->enum('supplier_type', ['local', 'international'])->default('local');

           $table->string('contact_person')->unique();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('address')->nullable();
            $table->string('postal_area')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('country')->default('Bangladesh');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('website')->nullable();
            $table->string('logo')->nullable();
            $table->string('tin')->nullable();
            $table->string('bin_number')->nullable();
            $table->string('currency')->default('BDT');
            $table->string('timezone')->default('Asia/Dhaka');
            $table->string('language')->default('en');
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['company_id', 'supplier_code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
