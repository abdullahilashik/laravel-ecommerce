<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    protected $cartService;
    protected $orderService;

    public function __construct(CartService $cartService, OrderService $orderService)
    {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }

    public function show()
    {
        $cartItems = $this->cartService->getCartItems();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = $this->cartService->getSubtotal();
        $shippingCost = 10.00;
        $total = $subtotal + $shippingCost;

        return view('checkout.index', compact('cartItems', 'subtotal', 'shippingCost', 'total'));
    }

    public function store(Request $request)
    {
        $cartItems = $this->cartService->getCartItems();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = $this->cartService->getSubtotal();
        $order = $this->orderService->createOrder(Auth::user(), $request->all(), $cartItems, $subtotal);

        $this->cartService->clear();

        return redirect()->route('order.confirmation', $order->id)->with('success', 'Order placed successfully!');
    }

    public function confirmation($id)
    {
        $order = \App\Models\Order::with('items.product')->findOrFail($id);
        return view('checkout.confirmation', compact('order'));
    }
}
