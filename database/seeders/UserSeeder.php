<?php

namespace Database\Seeders;

use App\Models\Admin\User;
use App\Models\Admin\Company;
use App\Models\Admin\Branch;
use App\Models\Admin\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all();

        foreach ($companies as $company) {
            // Get head office branch for this company
            $headOffice = Branch::where('company_id', $company->id)
                ->where('is_head_office', true)
                ->first();

            // Get IT department for this company
            $itDepartment = Department::where('company_id', $company->id)
                ->where('code', 'DEPT003') // IT department
                ->first();

            // Create Super Admin for each company
            $superAdmin = User::firstOrCreate(
                [
                    'email' => 'superadmin@' . strtolower(str_replace(' ', '', $company->name)) . '.com'
                ],
                [
                    'name' => 'Super Administrator - ' . $company->name,
                    'password' => Hash::make('admin@123'),
                    'avatar' => 'default_avatar.png',
                    'company_id' => $company->id,
                    'branch_id' => $headOffice ? $headOffice->id : null,
                    'department_id' => $itDepartment ? $itDepartment->id : null,
                    'phone' => '+880173317200' . rand(1, 9),
                    'language_preference' => 'en',
                    'is_active' => true,
                    'email_verified_at' => now(),
                    'last_login_at' => now(),
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            // Assign Super Admin role
            $superAdminRole = Role::where('name', 'Super Admin')->first();
            if ($superAdminRole) {
                $superAdmin->assignRole($superAdminRole);
            }

            // Create Admin user
            $admin = User::firstOrCreate(
                [
                    'email' => 'admin@' . strtolower(str_replace(' ', '', $company->name)) . '.com'
                ],
                [
                    'name' => 'Administrator - ' . $company->name,
                    'password' => Hash::make('admin@123'),
                    'avatar' => 'default_avatar.png',
                    'company_id' => $company->id,
                    'branch_id' => $headOffice ? $headOffice->id : null,
                    'department_id' => $itDepartment ? $itDepartment->id : null,
                    'phone' => '+880173317201' . rand(1, 9),
                    'language_preference' => 'en',
                    'is_active' => true,
                    'email_verified_at' => now(),
                    'created_by' => $superAdmin->id,
                    'updated_by' => $superAdmin->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            // Assign Admin role
            $adminRole = Role::where('name', 'Admin')->first();
            if ($adminRole) {
                $admin->assignRole($adminRole);
            }

            // Create Manager user
            $manager = User::firstOrCreate(
                [
                    'email' => 'manager@' . strtolower(str_replace(' ', '', $company->name)) . '.com'
                ],
                [
                    'name' => 'Manager - ' . $company->name,
                    'password' => Hash::make('manager@123'),
                    'avatar' => 'default_avatar.png',
                    'company_id' => $company->id,
                    'branch_id' => $headOffice ? $headOffice->id : null,
                    'department_id' => $itDepartment ? $itDepartment->id : null,
                    'phone' => '+880173317202' . rand(1, 9),
                    'language_preference' => 'en',
                    'is_active' => true,
                    'email_verified_at' => now(),
                    'created_by' => $superAdmin->id,
                    'updated_by' => $superAdmin->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            // Assign Manager role
            $managerRole = Role::where('name', 'Manager')->first();
            if ($managerRole) {
                $manager->assignRole($managerRole);
            }

            // Create Staff user
            $staff = User::firstOrCreate(
                [
                    'email' => 'staff@' . strtolower(str_replace(' ', '', $company->name)) . '.com'
                ],
                [
                    'name' => 'Staff Member - ' . $company->name,
                    'password' => Hash::make('staff@123'),
                    'avatar' => 'default_avatar.png',
                    'company_id' => $company->id,
                    'branch_id' => $headOffice ? $headOffice->id : null,
                    'department_id' => $itDepartment ? $itDepartment->id : null,
                    'phone' => '+880173317203' . rand(1, 9),
                    'language_preference' => 'en',
                    'is_active' => true,
                    'email_verified_at' => now(),
                    'created_by' => $superAdmin->id,
                    'updated_by' => $superAdmin->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            // Assign Staff role
            $staffRole = Role::where('name', 'Staff')->first();
            if ($staffRole) {
                $staff->assignRole($staffRole);
            }
        }

        $this->command->info('Users seeded successfully!');
        $this->command->info('Super Admin login: superadmin@asiaenterprisesltd.com / admin@123');
        $this->command->info('Admin login: admin@asiaenterprisesltd.com / admin@123');
        $this->command->info('Manager login: manager@asiaenterprisesltd.com / manager@123');
        $this->command->info('Staff login: staff@asiaenterprisesltd.com / staff@123');
    }
}
