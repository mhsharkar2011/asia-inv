<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade');
            $table->string('code')->unique();
            $table->string('warehouse_name');
            $table->text('address')->nullable();
            $table->decimal('capacity', 15, 2)->nullable();
            $table->string('current_occupancy')->nullable();
            $table->string('staff_count')->nullable();
            $table->foreignId('manager_id')->nullable()->constrained('users')->onDelete('set null');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warehouses');
    }
};
