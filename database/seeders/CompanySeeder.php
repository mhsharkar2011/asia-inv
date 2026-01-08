<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('companies')->insert([
            [
                'code' => 'AEL',
                'name' => 'Asia Enterprises Ltd.',
                'tin' => '123456789321',
                'bin' => '212233444444',
                'address' => '123 Main Street, Mumbai, Maharashtra',
                'country' => 'India',
                'currency' => 'INR',
                'fiscal_year_start' => '2024-04-01',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'TCL',
                'name' => 'Tech Solutions Ltd.',
                'tin' => '987654321123',
                'bin' => '333444555666',
                'address' => '456 Tech Park, Bangalore, Karnataka',
                'country' => 'India',
                'currency' => 'INR',
                'fiscal_year_start' => '2024-01-01',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        $this->command->info('Companies seeded successfully!');
    }
}
