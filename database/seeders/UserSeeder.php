<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            // Admin
            [
                'first_name' => 'Admin',
                'last_name'  => 'User',
                'email'      => 'admin@gmail.com',
                'phone'      => '+92 300 0000001',
                'password'   => '12345678',
                'role'       => 'admin',
            ],

            // Customers
            ['first_name' => 'user',    'last_name' => 'Khan',    'email' => 'user@gmail.com',             'phone' => '+92 300 1234567', 'role' => 'user'],
            ['first_name' => 'Zain',    'last_name' => 'Ali',     'email' => 'zain.ali@example.com',       'phone' => '+92 321 9876543', 'role' => 'user'],
            ['first_name' => 'Hira',    'last_name' => 'Malik',   'email' => 'hira.m@example.com',         'phone' => '+92 333 4455667', 'role' => 'user'],
            ['first_name' => 'Ali',     'last_name' => 'Raza',    'email' => 'ali.raza@example.com',       'phone' => '+92 345 1122334', 'role' => 'user'],
            ['first_name' => 'Sara',    'last_name' => 'Naeem',   'email' => 'sara.n@example.com',         'phone' => '+92 311 7788990', 'role' => 'user'],
            ['first_name' => 'Hamza',   'last_name' => 'Ahmed',   'email' => 'hamza98.dev@gmail.com',      'phone' => '+92 300 5556677', 'role' => 'user'],
            ['first_name' => 'Maryam',  'last_name' => 'Tariq',   'email' => 'maryam.t@example.com',       'phone' => '+92 322 9988776', 'role' => 'user'],
            ['first_name' => 'Bilal',   'last_name' => 'Ahmed',   'email' => 'bilal.ahmed@example.com',    'phone' => '+92 336 2233445', 'role' => 'user'],
            ['first_name' => 'Noor',    'last_name' => 'Fatima',  'email' => 'noor.f@example.com',         'phone' => '+92 315 6677889', 'role' => 'user'],
            ['first_name' => 'Hassan',  'last_name' => 'Khan',    'email' => 'hassan.k@example.com',       'phone' => '+92 302 4455661', 'role' => 'user'],
            ['first_name' => 'Fatima',  'last_name' => 'Sheikh',  'email' => 'fatima.s@example.com',       'phone' => '+92 300 7778899', 'role' => 'user'],
            ['first_name' => 'Usman',   'last_name' => 'Javed',   'email' => 'usman.j@example.com',        'phone' => '+92 321 1112233', 'role' => 'user'],
            ['first_name' => 'Areeba',  'last_name' => 'Noor',    'email' => 'areeba.noor@example.com',    'phone' => '+92 333 2223344', 'role' => 'user'],
            ['first_name' => 'Danish',  'last_name' => 'Raza',    'email' => 'danish.raza@example.com',    'phone' => '+92 345 3334455', 'role' => 'user'],
            ['first_name' => 'Laiba',   'last_name' => 'Shah',    'email' => 'laiba.shah@example.com',     'phone' => '+92 300 4445566', 'role' => 'user'],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'first_name' => $user['first_name'],
                    'last_name'  => $user['last_name'],
                    'phone'      => $user['phone'],
                    'password'   => Hash::make($user['password'] ?? 'password'),
                    'role'       => $user['role'],
                ]
            );
        }
    }
}

