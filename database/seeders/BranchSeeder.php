<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Admin\Company;
use App\Models\Admin\Branch;
use Carbon\Carbon;

class BranchSeeder extends Seeder
{
    public function run()
    {
        // Check if there are dependent records
        $hasDependencies = DB::table('users')->whereNotNull('branch_id')->exists();
                        //   DB::table('employees')->whereNotNull('branch_id')->exists() ||
                        //   DB::table('inventories')->whereNotNull('branch_id')->exists();

        if ($hasDependencies) {
            // Option 1: Set foreign keys to NULL first
            $this->clearDependencies();

            // Option 2: Or skip truncation and just delete non-dependent records
            $this->deleteOrphanedBranches();
        } else {
            // Safe to truncate
            Schema::disableForeignKeyConstraints();
            Branch::truncate();
            Schema::enableForeignKeyConstraints();
        }

        // Seed new branches
        $this->seedBranches();
    }

    private function clearDependencies()
    {
        // Set branch_id to NULL in dependent tables
        Schema::disableForeignKeyConstraints();

        DB::table('users')->update(['branch_id' => null]);
        // Add other dependent tables as needed
        // DB::table('employees')->update(['branch_id' => null]);
        // DB::table('inventories')->update(['branch_id' => null]);

        // Now truncate branches
        Branch::truncate();

        Schema::enableForeignKeyConstraints();
    }

    private function deleteOrphanedBranches()
    {
        // Delete only branches that have no dependencies
        $orphanedBranches = DB::table('branches as b')
            ->leftJoin('users as u', 'b.id', '=', 'u.branch_id')
            ->whereNull('u.id')
            ->select('b.id')
            ->get()
            ->pluck('id')
            ->toArray();

        if (!empty($orphanedBranches)) {
            Branch::whereIn('id', $orphanedBranches)->delete();
        }

        // For branches with dependencies, we can't delete them
        $dependentBranches = DB::table('branches as b')
            ->join('users as u', 'b.id', '=', 'u.branch_id')
            ->select('b.id', 'b.name', DB::raw('COUNT(u.id) as user_count'))
            ->groupBy('b.id', 'b.name')
            ->get();

        if ($dependentBranches->isNotEmpty()) {
            $this->command->warn('The following branches have dependencies and were not deleted:');
            foreach ($dependentBranches as $branch) {
                $this->command->line(" - {$branch->name} (ID: {$branch->id}) has {$branch->user_count} users");
            }
        }
    }

    private function seedBranches()
    {
        // Get all companies
        $companies = Company::all();

        if ($companies->isEmpty()) {
            $this->command->info('No companies found. Creating a demo company...');

            $companyId = DB::table('companies')->insertGetId([
                'name' => 'Demo Company Ltd.',
                'code' => 'COMP001',
                'email' => 'demo@company.com',
                'phone' => '+8801234567890',
                'address' => 'Dhaka, Bangladesh',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $companies = collect([(object)['id' => $companyId]]);
            $this->command->info("Demo company created with ID: {$companyId}");
        }

        $totalBranches = 0;

        foreach ($companies as $company) {
            $this->command->info("Creating branches for Company ID: {$company->id}");

            // Create head office
            $headOffice = Branch::create([
                'company_id' => $company->id,
                'code' => $this->generateBranchCode($company->id, 1),
                'name' => 'Head Office',
                'type' => 'office',
                'contact_person' => 'Managing Director',
                'email' => 'headoffice@company' . $company->id . '.com',
                'phone' => '+8802' . rand(8000000, 9999999),
                'mobile_phone' => '+8801' . rand(300000000, 999999999),
                'address' => '123 Business District, Dhaka',
                'postal_area' => 'Gulshan',
                'postal_code' => '1212',
                'city' => 'Dhaka',
                'district' => 'Dhaka',
                'country' => 'Bangladesh',
                'latitude' => 23.8103,
                'longitude' => 90.4125,
                'opening_time' => '08:30:00',
                'closing_time' => '17:30:00',
                'working_days' => 'Sunday-Thursday',
                'staff_count' => rand(50, 200),
                'area_sqft' => rand(5000, 20000),
                'is_head_office' => true,
                'is_active' => true,
                'has_warehouse' => false,
                'has_showroom' => true,
                'description' => 'Main corporate headquarters and administrative center.',
                'additional_info' => json_encode([
                    'floors' => rand(5, 15),
                    'parking_capacity' => rand(50, 200),
                    'conference_rooms' => rand(3, 8),
                    'established_year' => rand(2000, 2020),
                ]),
                'created_at' => Carbon::now()->subYears(rand(1, 5)),
                'updated_at' => Carbon::now(),
            ]);

            $totalBranches++;
            $this->command->info("  ✓ Created Head Office: {$headOffice->code} - {$headOffice->name}");

            // Create 3 retail branches
            for ($i = 1; $i <= 3; $i++) {
                $city = $this->getRandomCity();

                $branch = Branch::create([
                    'company_id' => $company->id,
                    'code' => $this->generateBranchCode($company->id, $i + 1),
                    'name' => $city['city'] . ' Retail Branch',
                    'type' => 'retail',
                    'contact_person' => 'Branch Manager ' . $i,
                    'email' => strtolower($city['city']) . '.branch@company' . $company->id . '.com',
                    'phone' => '+880' . rand(2, 9) . rand(1000000, 9999999),
                    'mobile_phone' => '+8801' . rand(300000000, 999999999),
                    'address' => rand(10, 999) . ' ' . $this->getRandomStreet() . ', ' . $city['city'],
                    'postal_area' => $this->getRandomArea($city['city']),
                    'postal_code' => $city['postal_code'],
                    'city' => $city['city'],
                    'district' => $city['district'],
                    'country' => 'Bangladesh',
                    'latitude' => $city['latitude'],
                    'longitude' => $city['longitude'],
                    'opening_time' => '09:00:00',
                    'closing_time' => '21:00:00',
                    'working_days' => 'Saturday-Thursday',
                    'staff_count' => rand(10, 30),
                    'area_sqft' => rand(2000, 8000),
                    'is_head_office' => false,
                    'is_active' => rand(0, 10) > 1,
                    'has_warehouse' => rand(0, 1),
                    'has_showroom' => true,
                    'description' => 'Retail outlet serving ' . $city['city'] . ' and surrounding areas.',
                    'additional_info' => json_encode([
                        'pos_terminals' => rand(2, 8),
                        'storage_capacity' => rand(1000, 5000) . ' sqft',
                        'delivery_service' => rand(0, 1) ? 'Yes' : 'No',
                        'year_opened' => rand(2015, 2023),
                    ]),
                    'created_at' => Carbon::now()->subMonths(rand(1, 36)),
                    'updated_at' => Carbon::now(),
                ]);

                $totalBranches++;
                $this->command->info("  ✓ Created {$city['city']} Branch: {$branch->code} - {$branch->name}");
            }
        }

        $this->command->info("✅ Successfully seeded {$totalBranches} branches!");
    }

    // Helper methods (simplified version)
    private function generateBranchCode($companyId, $branchNumber)
    {
        return 'BRN' . str_pad($companyId, 3, '0', STR_PAD_LEFT) . str_pad($branchNumber, 3, '0', STR_PAD_LEFT);
    }

    private function getRandomCity()
    {
        $cities = [
            ['city' => 'Dhaka', 'district' => 'Dhaka', 'postal_code' => '1000', 'latitude' => 23.8103, 'longitude' => 90.4125],
            ['city' => 'Chittagong', 'district' => 'Chittagong', 'postal_code' => '4000', 'latitude' => 22.3569, 'longitude' => 91.7832],
            ['city' => 'Khulna', 'district' => 'Khulna', 'postal_code' => '9000', 'latitude' => 22.8456, 'longitude' => 89.5403],
            ['city' => 'Rajshahi', 'district' => 'Rajshahi', 'postal_code' => '6000', 'latitude' => 24.3745, 'longitude' => 88.6042],
            ['city' => 'Sylhet', 'district' => 'Sylhet', 'postal_code' => '3100', 'latitude' => 24.8949, 'longitude' => 91.8687],
        ];

        return $cities[array_rand($cities)];
    }

    private function getRandomStreet()
    {
        $streets = ['Gulshan Avenue', 'Banani Road', 'Dhanmondi Road', 'Mirpur Road', 'Motijheel C/A'];
        return $streets[array_rand($streets)];
    }

    private function getRandomArea($city)
    {
        $areas = [
            'Dhaka' => ['Gulshan', 'Banani', 'Dhanmondi', 'Mirpur', 'Uttara'],
            'Chittagong' => ['Agrabad', 'GEC Circle', 'Nasirabad', 'Khulshi'],
            'Khulna' => ['Khulna City', 'Daulatpur', 'Sonadanga'],
            'default' => ['City Center', 'Main Area', 'Commercial Zone'],
        ];

        return isset($areas[$city])
            ? $areas[$city][array_rand($areas[$city])]
            : $areas['default'][array_rand($areas['default'])];
    }
}
