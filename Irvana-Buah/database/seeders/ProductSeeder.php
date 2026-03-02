<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil kategori yang sudah ada
        $lokal    = Category::where('slug', 'buah-lokal')->first();
        $impor    = Category::where('slug', 'buah-impor')->first();
        $tropis   = Category::where('slug', 'buah-tropis')->first();
        $musiman  = Category::where('slug', 'buah-musiman')->first();
        $berry    = Category::where('slug', 'buah-berry')->first();
        $citrus   = Category::where('slug', 'buah-citrus')->first();

        if (! $lokal || ! $impor || ! $tropis || ! $musiman || ! $berry || ! $citrus) {
            $this->command->error('Kategori belum ada. Jalankan CategorySeeder terlebih dahulu.');
            return;
        }

        $products = [

            // ── BUAH LOKAL ──────────────────────────────────────────────────
            [
                'category_id'    => $lokal->id,
                'name'           => 'Pisang Cavendish Premium',
                'price'          => 25000,
                'discount_price' => 20000,
                'stock'          => 150,
                'is_featured'    => true,
                'description'    => 'Pisang Cavendish pilihan langsung dari kebun Lampung. Manis, lembut, dan kaya potasium. Cocok untuk sarapan, smoothie, atau camilan sehat.',
                'image'          => 'https://images.unsplash.com/photo-1571771894821-ce9b6c11b08e?w=400&q=80',
            ],
            [
                'category_id'    => $lokal->id,
                'name'           => 'Pepaya California',
                'price'          => 18000,
                'discount_price' => null,
                'stock'          => 80,
                'is_featured'    => false,
                'description'    => 'Pepaya California manis dan bernutrisi tinggi. Daging buah oranye tebal, biji sedikit, dan kaya vitamin A & C. Per kilogram.',
                'image'          => 'https://images.unsplash.com/photo-1526318472351-c75fcf070305?w=400&q=80',
            ],
            [
                'category_id'    => $lokal->id,
                'name'           => 'Jambu Biji Merah',
                'price'          => 22000,
                'discount_price' => 18000,
                'stock'          => 60,
                'is_featured'    => false,
                'description'    => 'Jambu biji merah segar kaya vitamin C, bahkan 4x lebih banyak dari jeruk. Rasa manis-asam yang khas, daging tebal dan biji sedikit.',
                'image'          => 'https://images.unsplash.com/photo-1615485925600-97237c4fc1ec?w=400&q=80',
            ],
            [
                'category_id'    => $lokal->id,
                'name'           => 'Sawo Manila',
                'price'          => 30000,
                'discount_price' => null,
                'stock'          => 40,
                'is_featured'    => false,
                'description'    => 'Sawo Manila matang pohon dengan rasa manis karamel yang khas. Tekstur lembut dan kaya kandungan gula alami. Per kilogram.',
                'image'          => 'https://images.unsplash.com/photo-1604914169896-d5f4a0c6b6f1?w=400&q=80',
            ],
            [
                'category_id'    => $lokal->id,
                'name'           => 'Belimbing Madu',
                'price'          => 28000,
                'discount_price' => 23000,
                'stock'          => 50,
                'is_featured'    => true,
                'description'    => 'Belimbing madu Demak super manis dengan kadar gula tinggi. Bentuk bintang yang cantik, warna kuning cerah, dan rasa manis segar.',
                'image'          => 'https://images.unsplash.com/photo-1602524816295-c49e2b50d1ad?w=400&q=80',
            ],

            // ── BUAH IMPOR ──────────────────────────────────────────────────
            [
                'category_id'    => $impor->id,
                'name'           => 'Apel Fuji Jepang',
                'price'          => 65000,
                'discount_price' => 55000,
                'stock'          => 100,
                'is_featured'    => true,
                'description'    => 'Apel Fuji premium langsung dari Jepang. Rasa manis-segar, tekstur renyah, dan aroma khas. Kaya serat dan antioksidan. Per kilogram (±5-6 buah).',
                'image'          => 'https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?w=400&q=80',
            ],
            [
                'category_id'    => $impor->id,
                'name'           => 'Anggur Red Globe Chile',
                'price'          => 85000,
                'discount_price' => 72000,
                'stock'          => 70,
                'is_featured'    => true,
                'description'    => 'Anggur Red Globe impor dari Chile. Biji besar, rasa manis, dan kulit tipis. Cocok untuk camilan langsung atau dekorasi kue. Per kilogram.',
                'image'          => 'https://images.unsplash.com/photo-1537640538966-79f369143f8f?w=400&q=80',
            ],
            [
                'category_id'    => $impor->id,
                'name'           => 'Kiwi Zespri Gold',
                'price'          => 45000,
                'discount_price' => null,
                'stock'          => 90,
                'is_featured'    => false,
                'description'    => 'Kiwi Zespri Gold dari Selandia Baru. Daging buah kuning manis, kandungan vitamin C tinggi, dan tekstur lembut. Isi 4 buah per pack.',
                'image'          => 'https://images.unsplash.com/photo-1616684000067-36952fde56ec?w=400&q=80',
            ],
            [
                'category_id'    => $impor->id,
                'name'           => 'Pir Ya Li China',
                'price'          => 55000,
                'discount_price' => 47000,
                'stock'          => 60,
                'is_featured'    => false,
                'description'    => 'Pir Ya Li langsung dari China. Tekstur renyah-berair, rasa manis ringan, sangat menyegarkan. Kaya serat dan baik untuk pencernaan. Per kilogram.',
                'image'          => 'https://images.unsplash.com/photo-1514756331096-242fdeb70d4a?w=400&q=80',
            ],
            [
                'category_id'    => $impor->id,
                'name'           => 'Alpukat Hass Australia',
                'price'          => 78000,
                'discount_price' => null,
                'stock'          => 45,
                'is_featured'    => true,
                'description'    => 'Alpukat Hass premium dari Australia. Daging buah creamy, rasa gurih-lembut, kaya lemak sehat omega-3. Sempurna untuk guacamole atau toast. Per kilogram.',
                'image'          => 'https://images.unsplash.com/photo-1519162808019-7de1683fa2ad?w=400&q=80',
            ],

            // ── BUAH TROPIS ─────────────────────────────────────────────────
            [
                'category_id'    => $tropis->id,
                'name'           => 'Mangga Harum Manis',
                'price'          => 35000,
                'discount_price' => 29000,
                'stock'          => 120,
                'is_featured'    => true,
                'description'    => 'Mangga Harum Manis pilihan dari Probolinggo. Aroma harum menyengat, daging tebal, dan rasa manis legit. Tidak berserat. Per kilogram.',
                'image'          => 'https://images.unsplash.com/photo-1553279768-865429fa0078?w=400&q=80',
            ],
            [
                'category_id'    => $tropis->id,
                'name'           => 'Nanas Madu Subang',
                'price'          => 20000,
                'discount_price' => null,
                'stock'          => 85,
                'is_featured'    => false,
                'description'    => 'Nanas madu super manis dari Subang. Rendah asam, tinggi gula alami, dan kaya enzim bromelain yang baik untuk pencernaan. Per buah.',
                'image'          => 'https://images.unsplash.com/photo-1550258987-190a2d41a8ba?w=400&q=80',
            ],
            [
                'category_id'    => $tropis->id,
                'name'           => 'Kelapa Muda Hijau',
                'price'          => 15000,
                'discount_price' => null,
                'stock'          => 200,
                'is_featured'    => false,
                'description'    => 'Kelapa muda hijau segar langsung dari kebun. Air kelapa manis alami, daging kelapa muda lembut. Menyegarkan dan kaya elektrolit. Per buah.',
                'image'          => 'https://images.unsplash.com/photo-1580984969071-a8da5656c2fb?w=400&q=80',
            ],
            [
                'category_id'    => $tropis->id,
                'name'           => 'Rambutan Rapiah',
                'price'          => 25000,
                'discount_price' => 20000,
                'stock'          => 100,
                'is_featured'    => true,
                'description'    => 'Rambutan Rapiah premium — raja rambutan Indonesia. Daging tebal, kering, dan mudah lepas dari biji. Rasa manis legit. Per kilogram.',
                'image'          => 'https://images.unsplash.com/photo-1618897996318-5a901fa6ca71?w=400&q=80',
            ],
            [
                'category_id'    => $tropis->id,
                'name'           => 'Buah Naga Merah Super',
                'price'          => 38000,
                'discount_price' => 32000,
                'stock'          => 65,
                'is_featured'    => true,
                'description'    => 'Buah naga merah super ukuran besar dari Banyuwangi. Daging merah pekat kaya antioksidan, manis, dan menyegarkan. Per kilogram.',
                'image'          => 'https://images.unsplash.com/photo-1527325678964-54921661f888?w=400&q=80',
            ],
            [
                'category_id'    => $tropis->id,
                'name'           => 'Salak Pondoh',
                'price'          => 22000,
                'discount_price' => null,
                'stock'          => 75,
                'is_featured'    => false,
                'description'    => 'Salak Pondoh asli Sleman, Yogyakarta. Rasa manis-renyah yang khas, tidak sepat, dan daging tebal. Kaya vitamin C dan antioksidan. Per kilogram.',
                'image'          => 'https://images.unsplash.com/photo-1602524816295-c49e2b50d1ad?w=400&q=80',
            ],

            // ── BUAH MUSIMAN ────────────────────────────────────────────────
            [
                'category_id'    => $musiman->id,
                'name'           => 'Durian Musang King',
                'price'          => 150000,
                'discount_price' => 130000,
                'stock'          => 30,
                'is_featured'    => true,
                'description'    => 'Durian Musang King — raja durian premium dari Malaysia. Daging tebal berwarna kuning keemasan, rasa creamy-bitter yang khas, dan aroma kuat. Per kilogram.',
                'image'          => 'https://images.unsplash.com/photo-1580912533616-10f46e9dfdcf?w=400&q=80',
            ],
            [
                'category_id'    => $musiman->id,
                'name'           => 'Manggis Kalimantan',
                'price'          => 45000,
                'discount_price' => 38000,
                'stock'          => 55,
                'is_featured'    => true,
                'description'    => 'Manggis segar dari Kalimantan, si "ratu buah" tropis. Daging putih bersih, rasa manis-asam segar, dan kulit ungu gelap. Kaya xanthone. Per kilogram.',
                'image'          => 'https://images.unsplash.com/photo-1607920592519-bab4d9b5ec5d?w=400&q=80',
            ],
            [
                'category_id'    => $musiman->id,
                'name'           => 'Duku Palembang',
                'price'          => 40000,
                'discount_price' => null,
                'stock'          => 45,
                'is_featured'    => false,
                'description'    => 'Duku Palembang pilihan dengan kulit tipis dan biji kecil. Rasa manis legit, daging tebal dan berair. Hanya tersedia saat musim panen. Per kilogram.',
                'image'          => 'https://images.unsplash.com/photo-1600694524693-1d2e80d4a427?w=400&q=80',
            ],
            [
                'category_id'    => $musiman->id,
                'name'           => 'Lengkeng Diamond River',
                'price'          => 55000,
                'discount_price' => 48000,
                'stock'          => 40,
                'is_featured'    => false,
                'description'    => 'Lengkeng Diamond River impor dengan daging tebal, biji kecil, dan rasa sangat manis. Tersedia terbatas saat musim. Per kilogram.',
                'image'          => 'https://images.unsplash.com/photo-1604328702728-d0e5b92e2eb0?w=400&q=80',
            ],

            // ── BUAH BERRY ──────────────────────────────────────────────────
            [
                'category_id'    => $berry->id,
                'name'           => 'Strawberry Hidroponik Lokal',
                'price'          => 35000,
                'discount_price' => 29000,
                'stock'          => 80,
                'is_featured'    => true,
                'description'    => 'Strawberry segar dari kebun hidroponik Lembang, Bandung. Merah cerah, manis-asam segar, bebas pestisida. Kaya vitamin C dan antioksidan. Per 250 gram.',
                'image'          => 'https://images.unsplash.com/photo-1464965911861-746a04b4bca6?w=400&q=80',
            ],
            [
                'category_id'    => $berry->id,
                'name'           => 'Blueberry USA Import',
                'price'          => 75000,
                'discount_price' => 65000,
                'stock'          => 60,
                'is_featured'    => true,
                'description'    => 'Blueberry premium impor dari USA. Manis, berair, dan kaya antioksidan anthocyanin yang baik untuk otak dan mata. Per 125 gram.',
                'image'          => 'https://images.unsplash.com/photo-1498557850523-fd3d118b962e?w=400&q=80',
            ],
            [
                'category_id'    => $berry->id,
                'name'           => 'Raspberry Segar',
                'price'          => 85000,
                'discount_price' => null,
                'stock'          => 35,
                'is_featured'    => false,
                'description'    => 'Raspberry segar impor berwarna merah cerah. Rasa asam-manis yang khas, kaya serat dan antioksidan. Cocok untuk topping kue atau smoothie. Per 125 gram.',
                'image'          => 'https://images.unsplash.com/photo-1502741338009-cac2772e18bc?w=400&q=80',
            ],
            [
                'category_id'    => $berry->id,
                'name'           => 'Blackberry Premium',
                'price'          => 80000,
                'discount_price' => 70000,
                'stock'          => 30,
                'is_featured'    => false,
                'description'    => 'Blackberry hitam mengkilap dengan rasa manis-asam intens. Kaya vitamin K, C, dan mangan. Ideal untuk selai, pai, atau konsumsi langsung. Per 125 gram.',
                'image'          => 'https://images.unsplash.com/photo-1425934398893-310a009a77f9?w=400&q=80',
            ],

            // ── BUAH CITRUS ─────────────────────────────────────────────────
            [
                'category_id'    => $citrus->id,
                'name'           => 'Jeruk Pontianak Manis',
                'price'          => 28000,
                'discount_price' => 23000,
                'stock'          => 130,
                'is_featured'    => true,
                'description'    => 'Jeruk Pontianak terkenal se-Indonesia. Manis, berair banyak, dan aroma khas. Kaya vitamin C untuk daya tahan tubuh. Per kilogram.',
                'image'          => 'https://images.unsplash.com/photo-1547514701-42782101795e?w=400&q=80',
            ],
            [
                'category_id'    => $citrus->id,
                'name'           => 'Lemon California',
                'price'          => 45000,
                'discount_price' => null,
                'stock'          => 90,
                'is_featured'    => false,
                'description'    => 'Lemon California impor dengan kulit tipis dan kandungan jus tinggi. Asam segar, kaya vitamin C dan flavonoid. Cocok untuk minuman, masakan, dan kecantikan. Per kilogram.',
                'image'          => 'https://images.unsplash.com/photo-1590502593747-42a996133562?w=400&q=80',
            ],
            [
                'category_id'    => $citrus->id,
                'name'           => 'Jeruk Bali Merah',
                'price'          => 32000,
                'discount_price' => 27000,
                'stock'          => 70,
                'is_featured'    => false,
                'description'    => 'Jeruk Bali (pomelo) merah dengan daging segar berair dan rasa manis-asam khas. Ukuran besar, kaya serat dan vitamin C. Per buah (±1.5 kg).',
                'image'          => 'https://images.unsplash.com/photo-1589820296156-2454bb8a6ad1?w=400&q=80',
            ],
            [
                'category_id'    => $citrus->id,
                'name'           => 'Jeruk Mandarin Medan',
                'price'          => 38000,
                'discount_price' => 32000,
                'stock'          => 95,
                'is_featured'    => true,
                'description'    => 'Jeruk Mandarin Medan — manis legit dengan kulit mudah dikupas. Daging oranye berair banyak, biji sedikit, dan aroma wangi. Per kilogram.',
                'image'          => 'https://images.unsplash.com/photo-1611080626919-7cf5a9dbab12?w=400&q=80',
            ],
            [
                'category_id'    => $citrus->id,
                'name'           => 'Jeruk Nipis Segar',
                'price'          => 15000,
                'discount_price' => null,
                'stock'          => 160,
                'is_featured'    => false,
                'description'    => 'Jeruk nipis segar berkualitas tinggi. Sangat berair, asam segar, dan kaya vitamin C. Wajib ada di dapur — untuk masakan, minuman, dan perawatan alami. Per 500 gram.',
                'image'          => 'https://images.unsplash.com/photo-1551122089-4e4b61e8b29c?w=400&q=80',
            ],
        ];

        $count = 0;
        foreach ($products as $data) {
            $slug = Str::slug($data['name']);
            // Pastikan slug unik
            $originalSlug = $slug;
            $i = 1;
            while (Product::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $i++;
            }

            Product::updateOrCreate(
                ['slug' => Str::slug($data['name'])],
                array_merge($data, ['slug' => $slug, 'is_active' => true])
            );
            $count++;
        }

        $this->command->info("✅ {$count} produk buah berhasil dibuat.");
    }
}
