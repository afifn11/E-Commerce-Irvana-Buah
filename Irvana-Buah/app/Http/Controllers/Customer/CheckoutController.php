<?php

namespace App\Http\Controllers\Customer;

use App\DTO\CheckoutDTO;
use App\Exceptions\CartException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\ProcessCheckoutRequest;
use App\Models\Order;
use App\Services\CheckoutService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(
        private readonly CheckoutService $checkoutService,
    ) {}

    public function process(ProcessCheckoutRequest $request): RedirectResponse
    {
        try {
            $checkoutData = CheckoutDTO::fromRequest($request);
            $order        = $this->checkoutService->process(Auth::id(), $checkoutData);

            return redirect()->route('checkout.success', $order->id)
                ->with('success', "Pesanan berhasil dibuat! Nomor pesanan: {$order->order_number}");
        } catch (CartException $e) {
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        } catch (\Throwable $e) {
            Log::error("Checkout failed for user " . Auth::id() . ": " . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.');
        }
    }

    public function success(Order $order): View|RedirectResponse
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['orderItems.product', 'user']);

        return view('home.order-success', compact('order'));
    }
}
