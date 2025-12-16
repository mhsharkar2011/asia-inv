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
            $table->string('contact_person')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('gstin')->nullable();
            $table->string('pan_number')->nullable();
            $table->decimal('credit_limit', 15, 2)->nullable();
            $table->string('payment_terms')->nullable();
            $table->decimal('outstanding_balance', 15, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['company_id', 'supplier_code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
