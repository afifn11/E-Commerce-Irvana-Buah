<?php
namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        $coupons = [
            [
                'code'        => 'SELAMAT10',
                'type'        => 'percent',
                'value'       => 10,
                'min_order'   => 50000,
                'max_discount'=> 20000,
                'usage_limit' => null,
                'per_user_limit' => 1,
                'description' => 'Diskon 10% untuk pembelian pertama (maks Rp 20.000)',
                'is_active'   => true,
            ],
            [
                'code'        => 'GRATIS25K',
                'type'        => 'fixed',
                'value'       => 25000,
                'min_order'   => 100000,
                'max_discount'=> null,
                'usage_limit' => 50,
                'per_user_limit' => 1,
                'description' => 'Potongan langsung Rp 25.000 untuk order min. Rp 100.000',
                'expires_at'  => Carbon::now()->addMonths(3),
                'is_active'   => true,
            ],
            [
                'code'        => 'BUAH20',
                'type'        => 'percent',
                'value'       => 20,
                'min_order'   => 75000,
                'max_discount'=> 30000,
                'usage_limit' => 100,
                'per_user_limit' => 2,
                'description' => 'Diskon 20% khusus buah premium (maks Rp 30.000)',
                'expires_at'  => Carbon::now()->addMonth(),
                'is_active'   => true,
            ],
        ];

        foreach ($coupons as $data) {
            Coupon::firstOrCreate(['code' => $data['code']], $data);
        }
    }
}
