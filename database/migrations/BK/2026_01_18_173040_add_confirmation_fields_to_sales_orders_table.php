<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sales_orders', function (Blueprint $table) {
            $table->timestamp('confirmed_at')->nullable()->after('status');
            $table->foreignId('confirmed_by')->nullable()->after('confirmed_at')
                ->constrained('users')->onDelete('set null');

            // You might also want these fields for delivery/complete
            $table->timestamp('delivered_at')->nullable()->after('confirmed_at');
            $table->foreignId('delivered_by')->nullable()->after('delivered_at')
                ->constrained('users')->onDelete('set null');

            $table->timestamp('completed_at')->nullable()->after('delivered_at');
            $table->foreignId('completed_by')->nullable()->after('completed_at')
                ->constrained('users')->onDelete('set null');

            $table->timestamp('cancelled_at')->nullable()->after('completed_at');
            $table->foreignId('cancelled_by')->nullable()->after('cancelled_at')
                ->constrained('users')->onDelete('set null');
            $table->text('cancellation_reason')->nullable()->after('cancelled_by');
        });
    }

    public function down(): void
    {
        Schema::table('sales_orders', function (Blueprint $table) {
            $table->dropColumn([
                'confirmed_at',
                'confirmed_by',
                'delivered_at',
                'delivered_by',
                'completed_at',
                'completed_by',
                'cancelled_at',
                'cancelled_by',
                'cancellation_reason'
            ]);
        });
    }
};
