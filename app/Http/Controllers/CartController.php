<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cartItems = $this->cartService->getCartItems();
        [$subtotal, $shippingCost, $taxAmount, $total] = $this->totals();

        return view('cart.index', compact('cartItems', 'subtotal', 'shippingCost', 'taxAmount', 'total'));
    }

    public function updateAll(Request $request)
    {
        foreach ((array) $request->input('quantities', []) as $id => $quantity) {
            $this->cartService->update($id, (int) $quantity);
        }

        if ($request->expectsJson()) {
            return response()->json($this->cartPayload('Cart updated successfully!'));
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
    }

    public function clear(Request $request)
    {
        $this->cartService->clear();

        if ($request->expectsJson()) {
            return response()->json($this->cartPayload('Cart cleared.'));
        }

        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }

    protected function totals(): array
    {
        $subtotal = $this->cartService->getSubtotal();
        $shippingCost = 10.00;
        $taxAmount = round($subtotal * 0.05, 2);
        $total = $subtotal + $shippingCost + $taxAmount;

        return [$subtotal, $shippingCost, $taxAmount, $total];
    }

    public function add(Request $request, Product $product)
    {
        $quantity = max(1, (int) $request->input('quantity', 1));
        $this->cartService->add($product, $quantity);

        if ($request->expectsJson()) {
            return response()->json($this->cartPayload('Product added to cart successfully!'));
        }

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function update(Request $request, $id)
    {
        $quantity = $request->input('quantity', 1);
        $this->cartService->update($id, $quantity);

        if ($request->expectsJson()) {
            return response()->json($this->cartPayload('Cart updated successfully!'));
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
    }

    public function remove(Request $request, $id)
    {
        $this->cartService->remove($id);

        if ($request->expectsJson()) {
            return response()->json($this->cartPayload('Item removed from cart.'));
        }

        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }

    protected function cartPayload(string $message): array
    {
        $cartItems = $this->cartService->getCartItems();
        $subtotal = $this->cartService->getSubtotal();

        $renderDropdown = fn(string $prefix) => view('components.frontend.header.cart-dropdown', [
            'cartItems' => $cartItems,
            'cartSubtotal' => $subtotal,
            'prefix' => $prefix,
        ])->render();

        return [
            'success' => true,
            'message' => $message,
            'count' => $this->cartService->getCount(),
            'subtotal' => $subtotal,
            'dropdownDesktop' => $renderDropdown('d'),
            'dropdownMobile' => $renderDropdown('m'),
        ];
    }
}