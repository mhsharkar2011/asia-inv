<?php

namespace Database\Seeders;

use App\Models\Admin\Branch;
use App\Models\Admin\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $companies = Company::all();
            $cities = ['Chittagong', 'Khulna', 'Rajshahi', 'Sylhet', 'Barisal'];

            foreach ($companies as $company) {
                $slug = strtolower(preg_replace('/[^A-Za-z0-9]+/', '', $company->name));

                // --- Head office ---
                Branch::updateOrCreate(
                    [
                        'company_id' => $company->id,
                        'code'       => 'HO-' . $company->id,
                    ],
                    [
                        'name'            => $company->name . ' Head Office',
                        'type'            => 'office',
                        'contact_person'  => 'Ahmed Khan',
                        'designation'     => 'Executive',
                        'email'           => 'office@' . $slug . '.com',
                        'primary_phone'   => '+880' . rand(1700000000, 1999999999),
                        'secondary_phone' => '+880' . rand(1700000000, 1999999999),
                        'address'         => '123 Main Street',
                        'city'            => 'Dhaka',
                        'country'         => 'Bangladesh',
                        'postal_area'     => 'Mirpur',
                        'postal_code'     => '1200',
                        'opening_time'    => '09:00',
                        'closing_time'    => '18:00',
                        'working_days'    => 'Monday-Friday',
                        'staff_count'     => rand(10, 50),
                        'area_sqft'       => rand(2000, 5000),
                        'is_head_office'  => true,
                        'is_active'       => true,
                        'has_warehouse'   => true,
                        'description'     => 'Main head office location',
                    ]
                );

                // --- Retail branches ---
                for ($i = 1; $i <= 2; $i++) {
                    Branch::updateOrCreate(
                        [
                            'company_id' => $company->id,
                            'code'       => sprintf('BRN%03d-%02d', $company->id, $i),
                        ],
                        [
                            'name'            => $company->name . ' Branch ' . $i,
                            'type'            => 'retail',
                            'contact_person'  => 'Monir Hossain ' . $i,
                            'designation'     => 'Manager ' . $i,
                            'email'           => 'branch' . $i . '@' . $slug . '.com',
                            'primary_phone'   => '+880' . rand(1700000000, 1999999999),
                            'secondary_phone' => '+880' . rand(1700000000, 1999999999),
                            'address'         => $i . ' Branch Road',
                            'city'            => $cities[array_rand($cities)],
                            'country'         => 'Bangladesh',
                            'postal_code'     => '100' . $i,
                            'opening_time'    => '10:00',
                            'closing_time'    => '20:00',
                            'working_days'    => 'Sunday-Thursday',
                            'staff_count'     => rand(5, 20),
                            'area_sqft'       => rand(1000, 3000),
                            'is_head_office'  => false,
                            'is_active'       => true,
                            'has_showroom'    => true,
                            'description'     => 'Retail branch location',
                        ]
                    );
                }
            }
        });
    }
}
