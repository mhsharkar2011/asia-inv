<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Branch;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create default company
        $company = Company::create([
            'company_name' => 'Asia Enterprises Ltd.',
            'registration_no' => 'ABC123456',
            'tax_id' => 'GSTIN123456789',
            'address' => '123 Main Street, Mumbai, Maharashtra',
            'country' => 'India',
            'currency_base' => 'INR',
            'fiscal_year_start' => '2024-04-01',
            'gst_registered' => true,
        ]);

        // Create main branch
        $branch = Branch::create([
            'company_id' => $company->id,
            'branch_code' => 'BR001',
            'branch_name' => 'Main Branch',
            'address' => '123 Main Street, Mumbai, Maharashtra',
            'contact_person' => 'John Doe',
            'phone' => '+91-9876543210',
            'email' => 'main@asiaenterprise.com',
            'is_main_branch' => true,
        ]);

        // Create admin user
        User::create([
            'name' => 'System Administrator',
            'email' => 'admin@asiaenterprise.com',
            'password' => Hash::make('admin@123'),
            'company_id' => $company->id,
            'branch_id' => $branch->id,
            'username' => 'admin',
            'full_name' => 'System Administrator',
            'role' => 'admin',
            'phone' => '+91-9876543210',
            'language_preference' => 'en',
            'is_active' => true,
        ]);

        // Create categories
        $categories = [
            // Parent Categories
            [
                'company_id' => $company->id,
                'category_code' => 'ELEC',
                'category_name' => 'Electronics',
                'parent_category_id' => null,
                'description' => 'Electronic items and gadgets',
                'tax_rate_applicable' => 18.00,
            ],
            [
                'company_id' => $company->id,
                'category_code' => 'CLOTH',
                'category_name' => 'Clothing',
                'parent_category_id' => null,
                'description' => 'Apparel and clothing items',
                'tax_rate_applicable' => 12.00,
            ],
            [
                'company_id' => $company->id,
                'category_code' => 'FURN',
                'category_name' => 'Furniture',
                'parent_category_id' => null,
                'description' => 'Home and office furniture',
                'tax_rate_applicable' => 18.00,
            ],
            [
                'company_id' => $company->id,
                'category_code' => 'FOOD',
                'category_name' => 'Food & Beverages',
                'parent_category_id' => null,
                'description' => 'Food items and beverages',
                'tax_rate_applicable' => 5.00,
            ],
        ];

        foreach ($categories as $categoryData) {
            $category = Category::create($categoryData);

            // Create subcategories for Electronics
            if ($category->category_code == 'ELEC') {
                $subcategories = [
                    [
                        'company_id' => $company->id,
                        'category_code' => 'MOB',
                        'category_name' => 'Mobile Phones',
                        'parent_category_id' => $category->id,
                        'description' => 'Smartphones and mobile phones',
                        'tax_rate_applicable' => 18.00,
                    ],
                    [
                        'company_id' => $company->id,
                        'category_code' => 'LAP',
                        'category_name' => 'Laptops',
                        'parent_category_id' => $category->id,
                        'description' => 'Laptops and notebooks',
                        'tax_rate_applicable' => 18.00,
                    ],
                    [
                        'company_id' => $company->id,
                        'category_code' => 'TV',
                        'category_name' => 'Televisions',
                        'parent_category_id' => $category->id,
                        'description' => 'LED, LCD, and Smart TVs',
                        'tax_rate_applicable' => 28.00,
                    ],
                ];

                foreach ($subcategories as $subcatData) {
                    Category::create($subcatData);
                }
            }
        }
    }
}
