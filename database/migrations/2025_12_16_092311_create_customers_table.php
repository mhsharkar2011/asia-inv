<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->string('customer_code')->unique();
            $table->string('customer_name');
            $table->enum('customer_type', ['retail', 'wholesale', 'corporate'])->default('retail');
            $table->string('contact_person')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('tin')->nullable();
            $table->string('bin_number')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('bank_name')->nullable();
            $table->decimal('credit_limit', 15, 2)->nullable();
            $table->decimal('outstanding_balance', 15, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->string('web_address')->nullable();
            $table->string('industry')->nullable();
            $table->timestamps();

            $table->index(['company_id', 'customer_code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
