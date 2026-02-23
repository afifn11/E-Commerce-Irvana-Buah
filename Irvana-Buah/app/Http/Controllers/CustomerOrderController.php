<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['orderItems.product'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.orders', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['orderItems.product'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('customer.order-detail', compact('order'));
    }
}