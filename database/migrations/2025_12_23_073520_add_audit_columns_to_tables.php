<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // List of tables to add audit columns to
        $tables = [
            'users',
            'categories',
            'companies',
            'products',
            'invoices',
            'orders',
            'customers',
            'suppliers',
            'transactions',
            // Add other tables as needed
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $table) {
                    $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
                    $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
                    $table->foreignId('deleted_by')->nullable()->constrained('users')->onDelete('set null');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'users',
            'categories',
            'companies',
            'products',
            'invoices',
            'orders',
            'customers',
            'suppliers',
            'transactions',
            // Add other tables as needed
        ];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                    $table->dropForeign(['created_by']);
                    $table->dropForeign(['updated_by']);
                    $table->dropForeign(['deleted_by']);

                    $table->dropColumn(['created_by', 'updated_by', 'deleted_by']);
                });
            }
        }
    }
};
