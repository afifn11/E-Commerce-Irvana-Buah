<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\PointsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PointsController extends Controller
{
    public function __construct(private readonly PointsService $pointsService) {}

    public function index()
    {
        $balance      = $this->pointsService->getBalance(Auth::id());
        $transactions = $this->pointsService->getTransactionHistory(Auth::id(), 30);
        $redeemValue  = PointsService::pointsToRupiah($balance);

        return view('customer.points', compact('balance', 'transactions', 'redeemValue'));
    }

    /** AJAX: calculate redeem value */
    public function calculate(Request $request)
    {
        $points  = min((int) $request->points, $this->pointsService->getBalance(Auth::id()));
        $rupiah  = $points * PointsService::REDEEM_VALUE;
        return response()->json([
            'points'   => $points,
            'rupiah'   => $rupiah,
            'display'  => 'Rp ' . number_format($rupiah, 0, ',', '.'),
            'balance'  => $this->pointsService->getBalance(Auth::id()),
        ]);
    }
}
