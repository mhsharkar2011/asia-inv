<?php

namespace Database\Seeders;

use App\Models\Admin\Brand;
use App\Models\Admin\Company;
use App\Models\Admin\User;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all();
        $superAdmin = User::where('email', 'like', 'superadmin@%')->first();

        foreach ($companies as $company) {
            $brands = [
                [
                    'brand_code' => 'SAMSUNG',
                    'brand_name' => 'Samsung',
                    'description' => 'South Korean multinational electronics company',
                    'country_of_origin' => 'South Korea',
                    'is_active' => true,
                ],
                [
                    'brand_code' => 'SONY',
                    'brand_name' => 'Sony',
                    'description' => 'Japanese multinational conglomerate',
                    'country_of_origin' => 'Japan',
                    'is_active' => true,
                ],
                [
                    'brand_code' => 'HP',
                    'brand_name' => 'HP',
                    'description' => 'American multinational information technology company',
                    'country_of_origin' => 'USA',
                    'is_active' => true,
                ],
                [
                    'brand_code' => 'DELL',
                    'brand_name' => 'Dell',
                    'description' => 'American technology company',
                    'country_of_origin' => 'USA',
                    'is_active' => true,
                ],
                [
                    'brand_code' => 'LENOVO',
                    'brand_name' => 'Lenovo',
                    'description' => 'Chinese multinational technology company',
                    'country_of_origin' => 'China',
                    'is_active' => true,
                ],
                [
                    'brand_code' => 'XIAOMI',
                    'brand_name' => 'Xiaomi',
                    'description' => 'Chinese electronics company',
                    'country_of_origin' => 'China',
                    'is_active' => true,
                ],
                [
                    'brand_code' => 'CANON',
                    'brand_name' => 'Canon',
                    'description' => 'Japanese multinational corporation',
                    'country_of_origin' => 'Japan',
                    'is_active' => true,
                ],
                [
                    'brand_code' => 'ASUS',
                    'brand_name' => 'ASUS',
                    'description' => 'Taiwanese multinational computer and phone hardware company',
                    'country_of_origin' => 'Taiwan',
                    'is_active' => true,
                ],
            ];

            foreach ($brands as $brandData) {
                Brand::create([
                    'company_id' => $company->id,
                    'brand_code' => $brandData['brand_code'],
                    'brand_name' => $brandData['brand_name'],
                    'description' => $brandData['description'],
                    'country_of_origin' => $brandData['country_of_origin'],
                    'is_active' => $brandData['is_active'],
                    'created_by' => $superAdmin->id,
                    'updated_by' => $superAdmin->id,
                ]);
            }
        }

        $this->command->info('Brands seeded successfully!');
    }
}
