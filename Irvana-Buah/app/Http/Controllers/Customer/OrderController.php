<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository,
    ) {}

    public function index(): View
    {
        $orders = $this->orderRepository->getByUser(Auth::id());

        return view('customer.orders', compact('orders'));
    }

    public function show(int $id): View|RedirectResponse
    {
        try {
            $order = $this->orderRepository->findByUserOrFail($id, Auth::id());
            return view('customer.order-detail', compact('order'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException) {
            return redirect()->route('customer.orders')
                ->with('error', 'Pesanan tidak ditemukan.');
        }
    }
}
