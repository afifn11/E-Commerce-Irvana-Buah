<?php
namespace App\Services;

use App\Models\Order;
use App\Models\PointTransaction;
use App\Models\UserPoints;
use Illuminate\Support\Facades\DB;

class PointsService
{
    // 1 poin per Rp 1.000 belanja
    const EARN_RATE    = 1;
    const EARN_PER     = 1000;
    // 1 poin = Rp 10 diskon
    const REDEEM_VALUE = 10;

    public function getBalance(int $userId): int
    {
        return UserPoints::firstOrCreate(['user_id' => $userId], ['balance' => 0])->balance;
    }

    public function earn(int $userId, Order $order): int
    {
        $points = (int) floor(($order->total_amount / self::EARN_PER) * self::EARN_RATE);
        if ($points <= 0) return 0;

        return DB::transaction(function () use ($userId, $order, $points) {
            $wallet = UserPoints::firstOrCreate(['user_id' => $userId], ['balance' => 0]);
            $wallet->increment('balance', $points);
            $newBalance = $wallet->fresh()->balance;

            PointTransaction::create([
                'user_id'        => $userId,
                'amount'         => $points,
                'type'           => 'earn_order',
                'description'    => "Poin dari pesanan #{$order->order_number}",
                'reference_type' => Order::class,
                'reference_id'   => $order->id,
                'balance_after'  => $newBalance,
            ]);

            $order->update(['points_earned' => $points]);

            return $points;
        });
    }

    public function redeem(int $userId, int $points): float
    {
        $balance = $this->getBalance($userId);
        $points  = min($points, $balance);
        if ($points <= 0) return 0;

        $discount = $points * self::REDEEM_VALUE;

        DB::transaction(function () use ($userId, $points, $discount) {
            $wallet = UserPoints::where('user_id', $userId)->lockForUpdate()->first();
            $wallet->decrement('balance', $points);
            $newBalance = $wallet->fresh()->balance;

            PointTransaction::create([
                'user_id'       => $userId,
                'amount'        => -$points,
                'type'          => 'redeem_order',
                'description'   => "Penukaran {$points} poin (diskon Rp " . number_format($discount,0,',','.') . ")",
                'balance_after' => $newBalance,
            ]);
        });

        return $discount;
    }

    public function getTransactionHistory(int $userId, int $limit = 20)
    {
        return PointTransaction::where('user_id', $userId)
            ->latest()->limit($limit)->get();
    }

    public static function pointsToRupiah(int $points): string
    {
        return 'Rp ' . number_format($points * self::REDEEM_VALUE, 0, ',', '.');
    }
}
