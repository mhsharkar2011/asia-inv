<?php

namespace Database\Seeders;

use App\Models\LoginLog;
use App\Models\Admin\User;
use Illuminate\Database\Seeder;

class LoginLogsSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            if ($user->last_login_at) {
                LoginLog::create([
                    'user_id' => $user->id,
                    'ip_address' => '127.0.0.1',
                    'user_agent' => 'Seeder',
                    'login_type' => 'web',
                    'status' => 'success',
                    'logged_in_at' => $user->last_login_at,
                    'logged_out_at' => $user->last_login_at->addHour(),
                    'session_duration' => 3600, // 1 hour
                ]);
            }

            // Create some additional random login logs
            $randomCount = rand(0, 10);
            for ($i = 0; $i < $randomCount; $i++) {
                LoginLog::create([
                    'user_id' => $user->id,
                    'ip_address' => fake()->ipv4(),
                    'user_agent' => fake()->userAgent(),
                    'login_type' => 'web',
                    'status' => 'success',
                    'logged_in_at' => fake()->dateTimeBetween('-30 days', 'now'),
                    'logged_out_at' => fake()->dateTimeBetween('+1 hour', '+4 hours'),
                    'session_duration' => rand(1800, 14400), // 30 min to 4 hours
                ]);
            }
        }
    }
}
