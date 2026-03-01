<?php

namespace App\Http\Controllers\Customer;

use App\Exceptions\CartException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\AddToCartRequest;
use App\Http\Requests\Customer\UpdateCartRequest;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(
        private readonly CartService $cartService,
    ) {}

    public function index(): View|RedirectResponse
    {
        if (! Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu untuk melihat keranjang.');
        }

        $userId    = Auth::id();
        $cartItems = $this->cartService->getCartItems($userId);
        $totalPrice = $this->cartService->getTotalPrice($userId);

        return view('home.cart', compact('cartItems', 'totalPrice'));
    }

    public function store(AddToCartRequest $request): JsonResponse
    {
        try {
            $this->cartService->addProduct(
                userId:    Auth::id(),
                productId: $request->validated('product_id'),
                quantity:  $request->validated('quantity'),
            );

            $cartCount = $this->cartService->getCartCount(Auth::id());
            $productName = \App\Models\Product::find($request->product_id)?->name ?? 'Produk';

            return response()->json([
                'success'    => true,
                'message'    => "{$productName} berhasil ditambahkan ke keranjang.",
                'cart_count' => $cartCount,
            ]);
        } catch (CartException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function update(UpdateCartRequest $request, int $id): JsonResponse
    {
        try {
            $this->cartService->updateQuantity(Auth::id(), $id, $request->validated('quantity'));

            $userId     = Auth::id();
            $totalPrice = $this->cartService->getTotalPrice($userId);
            $cartCount  = $this->cartService->getCartCount($userId);

            return response()->json([
                'success'               => true,
                'message'               => 'Keranjang berhasil diperbarui.',
                'total_price'           => $totalPrice,
                'formatted_total_price' => 'Rp ' . number_format($totalPrice, 0, ',', '.'),
                'cart_count'            => $cartCount,
            ]);
        } catch (CartException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        $this->cartService->removeItem(Auth::id(), $id);

        $userId     = Auth::id();
        $totalPrice = $this->cartService->getTotalPrice($userId);
        $cartCount  = $this->cartService->getCartCount($userId);

        return response()->json([
            'success'               => true,
            'message'               => 'Produk berhasil dihapus dari keranjang.',
            'cart_count'            => $cartCount,
            'total_price'           => $totalPrice,
            'formatted_total_price' => 'Rp ' . number_format($totalPrice, 0, ',', '.'),
        ]);
    }

    public function clear(): RedirectResponse
    {
        $this->cartService->clearCart(Auth::id());

        return redirect()->route('cart.index')
            ->with('success', 'Keranjang berhasil dikosongkan.');
    }

    public function getCount(): JsonResponse
    {
        if (! Auth::check()) {
            return response()->json(['count' => 0]);
        }

        return response()->json(['count' => $this->cartService->getCartCount(Auth::id())]);
    }

    public function checkout(): View|RedirectResponse
    {
        if (! Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        try {
            $this->cartService->validateForCheckout(Auth::id());
        } catch (CartException $e) {
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }

        $userId     = Auth::id();
        $cartItems  = $this->cartService->getCartItems($userId);
        $totalPrice = $this->cartService->getTotalPrice($userId);

        return view('home.checkout', compact('cartItems', 'totalPrice'));
    }
}
