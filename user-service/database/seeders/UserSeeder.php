<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Import User model

class UserSeeder extends Seeder
{
    public function run()
    {
        // Menambahkan 10 data user statis
        User::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // Password yang terenkripsi
            'remember_token' => 'abc123',
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane.smith@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => 'def456',
        ]);

        User::create([
            'name' => 'Robert Johnson',
            'email' => 'robert.johnson@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => 'ghi789',
        ]);

        User::create([
            'name' => 'Emily Davis',
            'email' => 'emily.davis@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => 'jkl012',
        ]);

        User::create([
            'name' => 'Michael Brown',
            'email' => 'michael.brown@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => 'mno345',
        ]);

        User::create([
            'name' => 'Sarah Wilson',
            'email' => 'sarah.wilson@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => 'pqr678',
        ]);

        User::create([
            'name' => 'David Lee',
            'email' => 'david.lee@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => 'stu901',
        ]);

        User::create([
            'name' => 'Sophia Taylor',
            'email' => 'sophia.taylor@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => 'vwx234',
        ]);

        User::create([
            'name' => 'William Harris',
            'email' => 'william.harris@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => 'yz0123',
        ]);

        User::create([
            'name' => 'Olivia Clark',
            'email' => 'olivia.clark@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => 'abc987',
        ]);
    }
}
