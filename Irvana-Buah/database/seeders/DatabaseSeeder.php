<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name'              => 'Admin',
            'email'             => 'admin@irvanabuah.com',
            'password'          => bcrypt('admin123'),
            'role'              => 'admin',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name'              => 'Test User',
            'email'             => 'test@example.com',
            'password'          => bcrypt('user123'),
            'role'              => 'customer',
            'email_verified_at' => now(),
        ]);

        // Seed kategori & produk buah
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);

        $this->call(\Database\Seeders\CouponSeeder::class);
    }
}
