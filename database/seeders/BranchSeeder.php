<?php

namespace Database\Seeders;

use App\Models\Admin\Branch;
use App\Models\Admin\Company;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all();

        foreach ($companies as $company) {
            // Create head office branch
            $headOffice = Branch::create([
                'company_id' => $company->id,
                'branch_code' => 'HO-' . strtoupper(substr($company->name, 0, 3)),
                'branch_name' => $company->name . ' Head Office',
                'branch_type' => 'head_office',
                'contact_person' => 'Office Manager',
                'email' => 'office@' . strtolower(str_replace(' ', '', $company->name)) . '.com',
                'phone' => '+880' . rand(1700000000, 1999999999),
                'address_line_1' => '123 Main Street',
                'city' => 'Dhaka',
                'state' => 'Dhaka Division',
                'country' => 'Bangladesh',
                'postal_code' => '1200',
                'opening_time' => '09:00',
                'closing_time' => '18:00',
                'working_days' => 'Monday-Friday',
                'is_head_office' => true,
                'is_active' => true,
                'has_warehouse' => true,
                'description' => 'Main head office location',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Store head office ID for the company
            $company->head_office_id = $headOffice->id;
            $company->save();

            // Create retail branches
            for ($i = 1; $i <= 2; $i++) {
                $cities = ['Chittagong', 'Khulna', 'Rajshahi', 'Sylhet', 'Barisal'];

                Branch::create([
                    'company_id' => $company->id,
                    'branch_code' => 'BRN' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'branch_name' => $company->name . ' Branch ' . $i,
                    'branch_type' => 'retail',
                    'contact_person' => 'Branch Manager ' . $i,
                    'email' => 'branch' . $i . '@' . strtolower(str_replace(' ', '', $company->name)) . '.com',
                    'phone' => '+880' . rand(1700000000, 1999999999),
                    'address_line_1' => $i . ' Branch Road',
                    'city' => $cities[array_rand($cities)],
                    'state' => 'Division',
                    'country' => 'Bangladesh',
                    'postal_code' => '100' . $i,
                    'opening_time' => '10:00',
                    'closing_time' => '20:00',
                    'working_days' => 'Sunday-Thursday',
                    'is_head_office' => false,
                    'is_active' => true,
                    'has_showroom' => true,
                    'description' => 'Retail branch location',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->command->info('Branches seeded successfully!');
    }
}
