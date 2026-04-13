<?php

namespace Database\Seeders;

use App\Models\Admin\Brand;
use App\Models\Admin\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing brands
        Brand::query()->delete();

        $companies = Company::all();
        $userId = 1; // Assuming admin user ID is 1 for created_by and updated_by

        // Common brands that might exist in multiple companies
        $commonBrands = [
            [
                'name' => 'Samsung',
                'description' => 'South Korean multinational electronics company',
                'country_of_origin' => 'South Korea',
                'slug' => 'samsung',
            ],
            [
                'name' => 'Apple',
                'description' => 'American multinational technology company',
                'country_of_origin' => 'USA',
                'slug' => 'apple',
            ],
            [
                'name' => 'Sony',
                'description' => 'Japanese multinational conglomerate corporation',
                'country_of_origin' => 'Japan',
                'slug' => 'sony',
            ],
            [
                'name' => 'LG',
                'description' => 'South Korean multinational electronics company',
                'country_of_origin' => 'South Korea',
                'slug' => 'lg',
            ],
            [
                'name' => 'Philips',
                'description' => 'Dutch multinational conglomerate corporation',
                'country_of_origin' => 'Netherlands',
                'slug' => 'philips',
            ],
            [
                'name' => 'Panasonic',
                'description' => 'Japanese multinational electronics corporation',
                'country_of_origin' => 'Japan',
                'slug' => 'panasonic',
            ],
            [
                'name' => 'Toshiba',
                'description' => 'Japanese multinational conglomerate corporation',
                'country_of_origin' => 'Japan',
                'slug' => 'toshiba',
            ],
            [
                'name' => 'Hitachi',
                'description' => 'Japanese multinational conglomerate company',
                'country_of_origin' => 'Japan',
                'slug' => 'hitachi',
            ],
            [
                'name' => 'Sharp',
                'description' => 'Japanese multinational corporation',
                'country_of_origin' => 'Japan',
                'slug' => 'sharp',
            ],
            [
                'name' => 'Microsoft',
                'description' => 'American multinational technology corporation',
                'country_of_origin' => 'USA',
                'slug' => 'microsoft',
            ],
        ];

        // Industry-specific brands
        $electronicsBrands = [
            ['name' => 'Dell', 'country' => 'USA', 'slug' => 'dell'],
            ['name' => 'HP', 'country' => 'USA', 'slug' => 'hp'],
            ['name' => 'Lenovo', 'country' => 'China', 'slug' => 'lenovo'],
            ['name' => 'Acer', 'country' => 'Taiwan', 'slug' => 'acer'],
            ['name' => 'Asus', 'country' => 'Taiwan', 'slug' => 'asus'],
            ['name' => 'Intel', 'country' => 'USA', 'slug' => 'intel'],
            ['name' => 'AMD', 'country' => 'USA', 'slug' => 'amd'],
            ['name' => 'Nvidia', 'country' => 'USA', 'slug' => 'nvidia'],
            ['name' => 'Logitech', 'country' => 'Switzerland', 'slug' => 'logitech'],
            ['name' => 'Canon', 'country' => 'Japan', 'slug' => 'canon'],
        ];

        $applianceBrands = [
            ['name' => 'Whirlpool', 'country' => 'USA', 'slug' => 'whirlpool'],
            ['name' => 'Electrolux', 'country' => 'Sweden', 'slug' => 'electrolux'],
            ['name' => 'Bosch', 'country' => 'Germany', 'slug' => 'bosch'],
            ['name' => 'Siemens', 'country' => 'Germany', 'slug' => 'siemens'],
            ['name' => 'Miele', 'country' => 'Germany', 'slug' => 'miele'],
            ['name' => 'Haier', 'country' => 'China', 'slug' => 'haier'],
            ['name' => 'TCL', 'country' => 'China', 'slug' => 'tcl'],
            ['name' => 'Hisense', 'country' => 'China', 'slug' => 'hisense'],
        ];

        $fashionBrands = [
            ['name' => 'Nike', 'country' => 'USA', 'slug' => 'nike'],
            ['name' => 'Adidas', 'country' => 'Germany', 'slug' => 'adidas'],
            ['name' => 'Puma', 'country' => 'Germany', 'slug' => 'puma'],
            ['name' => 'Reebok', 'country' => 'USA', 'slug' => 'reebok'],
            ['name' => 'Levi\'s', 'country' => 'USA', 'slug' => 'levis'],
        ];

        foreach ($companies as $company) {
            $this->command->info("Creating brands for Company: {$company->name} (ID: {$company->id})");

            $brandCounter = 1;

            // Create common brands for each company
            foreach ($commonBrands as $brandData) {
                $code = $this->generateBrandCode($company->id, $brandCounter++);

                Brand::create([
                    'company_id' => $company->id,
                    'code' => $code,
                    'name' => $brandData['name'],
                    'description' => $brandData['description'],
                    'country_of_origin' => $brandData['country_of_origin'],
                    'slug' => $brandData['slug'] . '-' . $company->id, // Make slug company-specific
                    'is_active' => true,
                    'created_by' => $userId,
                    'updated_by' => $userId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $this->command->info("  ✓ Created: {$brandData['name']} (Code: {$code})");
            }

            // Add electronics brands for tech companies
            if (Str::contains(strtolower($company->name), ['tech', 'electronics', 'computer', 'digital'])) {
                foreach ($electronicsBrands as $brand) {
                    $code = $this->generateBrandCode($company->id, $brandCounter++);

                    Brand::create([
                        'company_id' => $company->id,
                        'code' => $code,
                        'name' => $brand['name'],
                        'description' => $brand['name'] . ' electronics and computing products',
                        'country_of_origin' => $brand['country'],
                        'slug' => $brand['slug'] . '-' . $company->id,
                        'is_active' => true,
                        'created_by' => $userId,
                        'updated_by' => $userId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // Add appliance brands for home goods companies
            if (Str::contains(strtolower($company->name), ['home', 'appliance', 'electric', 'household'])) {
                foreach ($applianceBrands as $brand) {
                    $code = $this->generateBrandCode($company->id, $brandCounter++);

                    Brand::create([
                        'company_id' => $company->id,
                        'code' => $code,
                        'name' => $brand['name'],
                        'description' => $brand['name'] . ' home appliances and electronics',
                        'country_of_origin' => $brand['country'],
                        'slug' => $brand['slug'] . '-' . $company->id,
                        'is_active' => true,
                        'created_by' => $userId,
                        'updated_by' => $userId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // Add fashion brands for clothing companies
            if (Str::contains(strtolower($company->name), ['fashion', 'clothing', 'apparel', 'textile'])) {
                foreach ($fashionBrands as $brand) {
                    $code = $this->generateBrandCode($company->id, $brandCounter++);

                    Brand::create([
                        'company_id' => $company->id,
                        'code' => $code,
                        'name' => $brand['name'],
                        'description' => $brand['name'] . ' fashion and apparel products',
                        'country_of_origin' => $brand['country'],
                        'slug' => $brand['slug'] . '-' . $company->id,
                        'is_active' => true,
                        'created_by' => $userId,
                        'updated_by' => $userId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // Create some company-specific brands
            $companySpecificBrands = [
                [
                    'name' => $company->name . ' Premium',
                    'description' => 'Premium product line from ' . $company->name,
                    'country' => 'Bangladesh',
                    'slug' => Str::slug($company->name) . '-premium',
                ],
                [
                    'name' => $company->name . ' Basics',
                    'description' => 'Basic affordable products from ' . $company->name,
                    'country' => 'Bangladesh',
                    'slug' => Str::slug($company->name) . '-basics',
                ],
                [
                    'name' => $company->name . ' Pro',
                    'description' => 'Professional grade products from ' . $company->name,
                    'country' => 'Bangladesh',
                    'slug' => Str::slug($company->name) . '-pro',
                ],
            ];

            foreach ($companySpecificBrands as $brand) {
                $code = $this->generateBrandCode($company->id, $brandCounter++);

                Brand::create([
                    'company_id' => $company->id,
                    'code' => $code,
                    'name' => $brand['name'],
                    'description' => $brand['description'],
                    'country_of_origin' => $brand['country'],
                    'slug' => $brand['slug'] . '-' . $company->id,
                    'is_active' => true,
                    'created_by' => $userId,
                    'updated_by' => $userId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $this->command->info("  ✓ Created company-specific: {$brand['name']} (Code: {$code})");
            }
        }

        $totalBrands = Brand::count();
        $this->command->info("✅ Successfully seeded {$totalBrands} brands!");

        // Show summary
        foreach ($companies as $company) {
            $brandCount = Brand::where('company_id', $company->id)->count();
            $this->command->info("Company {$company->name}: {$brandCount} brands");
        }
    }

    /**
     * Generate unique brand code per company
     */
    private function generateBrandCode($companyId, $counter): string
    {
        // Option 1: Include company ID in code
        // return 'BRAND-' . str_pad($companyId, 3, '0', STR_PAD_LEFT) . '-' . str_pad($counter, 4, '0', STR_PAD_LEFT);

        // Option 2: Simple format
        return 'BR' . str_pad($companyId, 2, '0', STR_PAD_LEFT) . str_pad($counter, 4, '0', STR_PAD_LEFT);

        // Option 3: First letters of brand + company + counter
        // return substr($brandName, 0, 3) . str_pad($companyId, 2, '0', STR_PAD_LEFT) . str_pad($counter, 3, '0', STR_PAD_LEFT);
    }
}
