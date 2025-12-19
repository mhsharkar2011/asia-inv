<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear tables
        DB::table('categories')->truncate();
        DB::table('users')->truncate();
        // DB::table('branches')->truncate();
        DB::table('organizations')->truncate();

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Insert company
        $companyId = DB::table('organizations')->insertGetId([
            'code' => 'AEL.',
            'name' => 'Asia Enterprises Ltd.',
            'tin' => '123456789321',
            'bin' => '212233444444',
            'address' => '123 Main Street, Mumbai, Maharashtra',
            'country' => 'India',
            'currency' => 'INR',
            'fiscal_year_start' => '2024-04-01',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert branch
        // $branchId = DB::table('branches')->insertGetId([
        //     'company_id' => $companyId,
        //     'branch_code' => 'BR001',
        //     'branch_name' => 'Main Branch',
        //     'address' => '123 Main Street, Mumbai, Maharashtra',
        //     'contact_person' => 'John Doe',
        //     'phone' => '+91-9876543210',
        //     'email' => 'main@asiaenterprise.com',
        //     'is_main_branch' => true,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        // Insert users
        DB::table('users')->insert([
            [
                'name' => 'System Administrator',
                'email' => 'admin@asiaenterprise.com',
                'password' => Hash::make('admin@123'),
                'avatar' => 'default_avatar.png',
                'company_id' => $companyId,
                // 'branch_id' => $branchId,
                'role' => 'admin',
                'phone' => '+8801733172007',
                'language_preference' => 'en',
                'is_active' => true,
                'email_verified_at' => now(),
                'last_login_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Insert categories
        $electronicsId = DB::table('categories')->insertGetId([
            'company_id' => $companyId,
            'category_code' => 'ELEC',
            'category_name' => 'Electronics',
            'parent_category_id' => null,
            'description' => 'Electronic items and gadgets',
            'tax_rate_applicable' => 18.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $clothingId = DB::table('categories')->insertGetId([
            'company_id' => $companyId,
            'category_code' => 'CLOTH',
            'category_name' => 'Clothing',
            'parent_category_id' => null,
            'description' => 'Apparel and clothing items',
            'tax_rate_applicable' => 12.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert subcategories
        DB::table('categories')->insert([
            [
                'company_id' => $companyId,
                'category_code' => 'MOB',
                'category_name' => 'Mobile Phones',
                'parent_category_id' => $electronicsId,
                'description' => 'Smartphones and mobile phones',
                'tax_rate_applicable' => 18.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_id' => $companyId,
                'category_code' => 'LAP',
                'category_name' => 'Laptops',
                'parent_category_id' => $electronicsId,
                'description' => 'Laptops and notebooks',
                'tax_rate_applicable' => 18.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_id' => $companyId,
                'category_code' => 'MEN',
                'category_name' => "Men's Wear",
                'parent_category_id' => $clothingId,
                'description' => 'Clothing for men',
                'tax_rate_applicable' => 12.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_id' => $companyId,
                'category_code' => 'WOMEN',
                'category_name' => "Women's Wear",
                'parent_category_id' => $clothingId,
                'description' => 'Clothing for women',
                'tax_rate_applicable' => 12.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $this->command->info('Database seeded successfully!');
        $this->command->info('Login credentials:');
        $this->command->info('Admin: admin / admin@123');
        $this->command->info('Staff: staff / staff@123');
    }
}
