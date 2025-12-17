<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('registration_no')->nullable();
            $table->string('tax_id')->nullable();
            $table->text('address');
            $table->string('country');
            $table->string('currency_base', 3)->default('INR');
            $table->date('fiscal_year_start');
            $table->boolean('gst_registered')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('companies');
    }
};
