<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Superadmin
        User::create([
            'name' => 'Super Administrator',
            'email' => 'admin@example.com',
            'password' => 'password',
            'role' => 'superadmin',
            'nip' => '199001012020011001',
            'position' => 'Administrator Sistem',
            'department' => 'IT',
            'phone' => '081234567890',
            'is_active' => true,
        ]);

        // Create Demo User
        User::create([
            'name' => 'Demo User',
            'email' => 'user@example.com',
            'password' => 'password123',
            'role' => 'user',
            'nip' => '199505052021012001',
            'position' => 'Staff',
            'department' => 'Umum',
            'phone' => '081234567891',
            'is_active' => true,
        ]);
    }
}
