<?php

namespace Database\Seeders;

use App\Models\LoginLog;
use App\Models\Admin\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class LoginLogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->info('No users found. Please run UsersSeeder first.');
            return;
        }

        $userAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'PostmanRuntime/7.26.8',
            'curl/7.68.0',
        ];

        $loginTypes = ['web', 'api', 'mobile'];
        $failureReasons = ['Invalid credentials', 'Account locked', 'IP blocked', 'Session expired'];

        foreach ($users as $user) {
            // Create login log from user's last_login_at if exists
            if ($user->last_login_at) {
                LoginLog::create([
                    'user_id' => $user->id,
                    'ip_address' => '127.0.0.1',
                    'user_agent' => 'Seeder',
                    'login_type' => 'web',
                    'status' => 'success',
                    'logged_in_at' => $user->last_login_at,
                    'logged_out_at' => $user->last_login_at->copy()->addHour(),
                    'session_duration' => 3600,
                ]);
            }

            // Create additional login logs
            $randomCount = rand(5, 15);
            for ($i = 0; $i < $randomCount; $i++) {
                $loginTime = Carbon::now()->subDays(rand(1, 30))->subHours(rand(1, 12));
                $hasLogout = rand(0, 100) <= 80;
                $logoutTime = $hasLogout ? $loginTime->copy()->addHours(rand(1, 4)) : null;
                $status = rand(0, 10) < 2 ? 'failed' : 'success';

                LoginLog::create([
                    'user_id' => $user->id,
                    'ip_address' => $this->generateRandomIp(),
                    'user_agent' => $userAgents[array_rand($userAgents)],
                    'login_type' => $loginTypes[array_rand($loginTypes)],
                    'status' => $status,
                    'logged_in_at' => $loginTime,
                    'logged_out_at' => $logoutTime,
                    'session_duration' => $logoutTime ? $logoutTime->diffInSeconds($loginTime) : null,
                    'failure_reason' => $status === 'failed' ? $failureReasons[array_rand($failureReasons)] : null,
                ]);
            }
        }

        $this->command->info('Login logs seeded successfully!');
        $this->command->info('Total login logs created: ' . LoginLog::count());
    }

    private function generateRandomIp(): string
    {
        return rand(1, 255) . '.' . rand(0, 255) . '.' . rand(0, 255) . '.' . rand(0, 255);
    }
}
