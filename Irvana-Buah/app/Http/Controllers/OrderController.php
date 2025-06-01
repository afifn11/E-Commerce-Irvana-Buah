<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{
    /**
     * Display a listing of orders for web interface
     */
    public function index(Request $request)
    {
        // Check if request wants JSON (API)
        if ($request->wantsJson() || $request->is('api/*')) {
            return $this->indexApi($request);
        }

        $query = Order::with(['user', 'orderItems']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Search by order number or user name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', '%' . $search . '%')
                               ->orWhere('email', 'like', '%' . $search . '%');
                  });
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(15);
        $users = User::orderBy('name')->get();

        return view('orders.index', compact('orders', 'users'));
    }

    /**
     * API version of index method
     */
    public function indexApi(Request $request): JsonResponse
    {
        $query = Order::with(['user', 'orderItems']);

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->has('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by user
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Search by order number
        if ($request->has('search')) {
            $query->where('order_number', 'like', '%' . $request->search . '%');
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    /**
     * Show the form for creating a new order
     */
    public function create(): View
    {
        $users = User::orderBy('name')->get();
        return view('orders.create', compact('users'));
    }

    /**
     * Store a newly created order
     */
    public function store(Request $request)
    {
        // Check if request wants JSON (API)
        if ($request->wantsJson() || $request->is('api/*')) {
            return $this->storeApi($request);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|string|in:pending,processing,shipped,delivered,cancelled',
            'payment_method' => 'required|string|in:cash,credit_card,bank_transfer,e_wallet',
            'payment_status' => 'required|string|in:pending,paid,failed,refunded',
            'shipping_address' => 'required|string|max:500',
            'shipping_phone' => 'required|string|max:20',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        DB::beginTransaction();
        try {
            $orderData = $request->all();
            $orderData['order_number'] = $this->generateOrderNumber();

            $order = Order::create($orderData);

            DB::commit();

            return redirect()->route('orders.index')
                           ->with('success', 'Order berhasil dibuat');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                           ->with('error', 'Gagal membuat order: ' . $e->getMessage())
                           ->withInput();
        }
    }

    /**
     * API version of store method
     */
    public function storeApi(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|string|in:pending,processing,shipped,delivered,cancelled',
            'payment_method' => 'required|string|in:cash,credit_card,bank_transfer,e_wallet',
            'payment_status' => 'required|string|in:pending,paid,failed,refunded',
            'shipping_address' => 'required|string|max:500',
            'shipping_phone' => 'required|string|max:20',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $orderData = $request->all();
            $orderData['order_number'] = $this->generateOrderNumber();

            $order = Order::create($orderData);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'data' => $order->load(['user', 'orderItems'])
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified order
     */
    public function show($id)
    {
        $order = Order::with(['user', 'orderItems.product'])->find($id);

        if (!$order) {
            // Check if request wants JSON (API)
            if (request()->wantsJson() || request()->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            return redirect()->route('orders.index')
                           ->with('error', 'Order tidak ditemukan');
        }

        // Check if request wants JSON (API)
        if (request()->wantsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => $order
            ]);
        }

        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified order
     */
    public function edit($id): View|RedirectResponse
    {
        $order = Order::with(['user', 'orderItems'])->find($id);

        if (!$order) {
            return redirect()->route('orders.index')
                           ->with('error', 'Order tidak ditemukan');
        }

        $users = User::orderBy('name')->get();
        
        return view('orders.edit', compact('order', 'users'));
    }

    /**
     * Update the specified order
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            // Check if request wants JSON (API)
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            return redirect()->route('orders.index')
                           ->with('error', 'Order tidak ditemukan');
        }

        // Check if request wants JSON (API)
        if ($request->wantsJson() || $request->is('api/*')) {
            return $this->updateApi($request, $id);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'sometimes|exists:users,id',
            'total_amount' => 'sometimes|numeric|min:0',
            'status' => 'sometimes|string|in:pending,processing,shipped,delivered,cancelled',
            'payment_method' => 'sometimes|string|in:cash,credit_card,bank_transfer,e_wallet',
            'payment_status' => 'sometimes|string|in:pending,paid,failed,refunded',
            'shipping_address' => 'sometimes|string|max:500',
            'shipping_phone' => 'sometimes|string|max:20',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        DB::beginTransaction();
        try {
            $order->update($request->all());
            DB::commit();

            return redirect()->route('orders.show', $order->id)
                           ->with('success', 'Order berhasil diupdate');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                           ->with('error', 'Gagal mengupdate order: ' . $e->getMessage())
                           ->withInput();
        }
    }

    /**
     * API version of update method
     */
    public function updateApi(Request $request, $id): JsonResponse
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'sometimes|exists:users,id',
            'total_amount' => 'sometimes|numeric|min:0',
            'status' => 'sometimes|string|in:pending,processing,shipped,delivered,cancelled',
            'payment_method' => 'sometimes|string|in:cash,credit_card,bank_transfer,e_wallet',
            'payment_status' => 'sometimes|string|in:pending,paid,failed,refunded',
            'shipping_address' => 'sometimes|string|max:500',
            'shipping_phone' => 'sometimes|string|max:20',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $order->update($request->all());
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order updated successfully',
                'data' => $order->load(['user', 'orderItems'])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified order
     */
    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            // Check if request wants JSON (API)
            if (request()->wantsJson() || request()->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            return redirect()->route('orders.index')
                           ->with('error', 'Order tidak ditemukan');
        }

        // Check if request wants JSON (API)
        if (request()->wantsJson() || request()->is('api/*')) {
            return $this->destroyApi($id);
        }

        DB::beginTransaction();
        try {
            $order->delete();
            DB::commit();

            return redirect()->route('orders.index')
                           ->with('success', 'Order berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('orders.index')
                           ->with('error', 'Gagal menghapus order: ' . $e->getMessage());
        }
    }

    /**
     * API version of destroy method
     */
    public function destroyApi($id): JsonResponse
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        DB::beginTransaction();
        try {
            $order->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order deleted successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, $id): JsonResponse
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|string|in:pending,processing,shipped,delivered,cancelled'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $order->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully',
            'data' => $order->load(['user', 'orderItems'])
        ]);
    }

    /**
     * Update payment status
     */
    public function updatePaymentStatus(Request $request, $id): JsonResponse
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'payment_status' => 'required|string|in:pending,paid,failed,refunded'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $order->update(['payment_status' => $request->payment_status]);

        return response()->json([
            'success' => true,
            'message' => 'Payment status updated successfully',
            'data' => $order->load(['user', 'orderItems'])
        ]);
    }

    /**
     * Get orders by user
     */
    public function getByUser($userId): JsonResponse
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        $orders = Order::with('orderItems')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    /**
     * Generate unique order number
     */
    private function generateOrderNumber(): string
    {
        do {
            $orderNumber = 'ORD-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (Order::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }

    /**
     * Get order statistics
     */
    public function statistics(): JsonResponse
    {
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'processing_orders' => Order::where('status', 'processing')->count(),
            'shipped_orders' => Order::where('status', 'shipped')->count(),
            'delivered_orders' => Order::where('status', 'delivered')->count(),
            'cancelled_orders' => Order::where('status', 'cancelled')->count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total_amount'),
            'pending_payments' => Order::where('payment_status', 'pending')->sum('total_amount'),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}