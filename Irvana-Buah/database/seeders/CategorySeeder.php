<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name'        => 'Buah Lokal',
                'description' => 'Buah-buahan segar pilihan dari petani lokal Indonesia, berkualitas tinggi dan harga terjangkau.',
                'image'       => 'https://images.unsplash.com/photo-1490474418585-ba9bad8fd0ea?w=400&q=80',
            ],
            [
                'name'        => 'Buah Impor',
                'description' => 'Buah-buahan pilihan dari luar negeri, langsung diimpor untuk menjaga kesegaran dan kualitas.',
                'image'       => 'https://images.unsplash.com/photo-1619566636858-adf3ef46400b?w=400&q=80',
            ],
            [
                'name'        => 'Buah Tropis',
                'description' => 'Koleksi buah tropis khas Nusantara yang kaya rasa dan nutrisi.',
                'image'       => 'https://images.unsplash.com/photo-1511688878353-3a2f5be94cd7?w=400&q=80',
            ],
            [
                'name'        => 'Buah Musiman',
                'description' => 'Buah-buahan terbaik yang hanya tersedia di musim tertentu. Pesan sekarang sebelum kehabisan!',
                'image'       => 'https://images.unsplash.com/photo-1528821128474-27f963b062bf?w=400&q=80',
            ],
            [
                'name'        => 'Buah Berry',
                'description' => 'Berbagai jenis buah beri segar, kaya antioksidan dan cocok untuk camilan sehat.',
                'image'       => 'https://images.unsplash.com/photo-1464965911861-746a04b4bca6?w=400&q=80',
            ],
            [
                'name'        => 'Buah Citrus',
                'description' => 'Aneka buah jeruk dan citrus kaya vitamin C, menyegarkan dan menyehatkan.',
                'image'       => 'https://images.unsplash.com/photo-1547514701-42782101795e?w=400&q=80',
            ],
        ];

        foreach ($categories as $data) {
            Category::updateOrCreate(
                ['slug' => Str::slug($data['name'])],
                [
                    'name'        => $data['name'],
                    'slug'        => Str::slug($data['name']),
                    'description' => $data['description'],
                    'image'       => $data['image'],
                ]
            );
        }

        $this->command->info('✅ ' . count($categories) . ' kategori berhasil dibuat.');
    }
}
