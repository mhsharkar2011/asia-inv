## Use Iconify with Tailwind:

Install Iconify:
bash
npm install @iconify/iconify

## media Upload

composer require spatie/laravel-medialibrary

## Migrations

1. Create a Migration for Adding Audit Columns

php artisan make:migration add_audit_columns_to_tables

2. Update Your Existing Migrations

// Audit columns
$table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
$table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
$table->foreignId('deleted_by')->nullable()->constrained('users')->onDelete('set null');

3. Create an Activity Logs Table (Optional but Recommended)

php artisan make:migration create_activity_logs_table


4. Update Your Models

## Base Model Approach (Recommended)
Create a base model that all your models extend:
