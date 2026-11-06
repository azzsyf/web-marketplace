<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin user
        User::updateOrCreate(
            ['email' => 'admin@bakoeljaersey.com'],
            [
                'name' => 'Admin Bakoel',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '081234567890',
                'address' => 'Jl. Stadion Utama No. 1, Jakarta',
            ]
        );

        // Customer user
        User::updateOrCreate(
            ['email' => 'customer@bakoeljaersey.com'],
            [
                'name' => 'Budi Customer',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'phone' => '089876543210',
                'address' => 'Jl. Suporter Setia No. 99, Bandung',
            ]
        );
    }
}

