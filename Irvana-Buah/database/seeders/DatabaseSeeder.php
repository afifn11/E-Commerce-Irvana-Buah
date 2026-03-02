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
        // Buat admin & user test
        User::factory()->create([
            'name'  => 'Admin',
            'email' => 'admin@irvanabuah.com',
            'role'  => 'admin',
        ]);

        User::factory()->create([
            'name'  => 'Test User',
            'email' => 'test@example.com',
            'role'  => 'customer',
        ]);

        // Seed kategori & produk buah
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
