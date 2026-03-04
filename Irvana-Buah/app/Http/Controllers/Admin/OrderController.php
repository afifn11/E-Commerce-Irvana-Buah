<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateOrderRequest;
use App\Models\Order;
use App\Models\User;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusMail;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository,
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['status', 'payment_status', 'user_id', 'search']);
        $orders  = $this->orderRepository->getPaginatedWithFilters($filters);
        $stats   = $this->orderRepository->getStatistics();
        $users   = User::orderBy('name')->get();

        return view('orders.index', compact('orders', 'users', 'stats'));
    }

    public function show(int $id): View|RedirectResponse
    {
        $order = $this->orderRepository->findById($id);

        if (! $order) {
            return redirect()->route('admin.orders.index')->with('error', 'Pesanan tidak ditemukan.');
        }

        return view('orders.show', compact('order'));
    }

    public function edit(int $id): View|RedirectResponse
    {
        $order = $this->orderRepository->findById($id);

        if (! $order) {
            return redirect()->route('admin.orders.index')->with('error', 'Pesanan tidak ditemukan.');
        }

        $users = User::orderBy('name')->get();

        return view('orders.edit', compact('order', 'users'));
    }

    public function update(UpdateOrderRequest $request, Order $order): RedirectResponse
    {
        $this->orderRepository->update($order, $request->validated());

        return redirect()->route('admin.orders.show', $order->id)
            ->with('success', 'Pesanan berhasil diperbarui.');
    }

    public function destroy(Order $order): RedirectResponse
    {
        $this->orderRepository->delete($order);

        return redirect()->route('admin.orders.index')
            ->with('success', 'Pesanan berhasil dihapus.');
    }

    public function updateStatus(Request $request, Order $order): JsonResponse
    {
        $request->validate([
            'status' => ['required', 'in:' . implode(',', \App\Enums\OrderStatus::values())],
        ]);

        $this->orderRepository->update($order, ['status' => $request->status]);

        // Send notification email to customer
        try {
            $order->load(['orderItems.product', 'user']);
            Mail::to($order->user->email)->send(new OrderStatusMail($order));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Order status mail failed: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Status pesanan berhasil diperbarui.',
        ]);
    }

    public function updatePaymentStatus(Request $request, Order $order): JsonResponse
    {
        $request->validate([
            'payment_status' => ['required', 'in:' . implode(',', \App\Enums\PaymentStatus::values())],
        ]);

        $this->orderRepository->update($order, ['payment_status' => $request->payment_status]);

        return response()->json([
            'success' => true,
            'message' => 'Status pembayaran berhasil diperbarui.',
        ]);
    }
}
