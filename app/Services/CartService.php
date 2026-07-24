<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    protected function getIdentifier()
    {
        if (Auth::check()) {
            return ['user_id' => Auth::id()];
        }

        if (!Session::has('cart_session_id')) {
            Session::put('cart_session_id', uniqid('cart_', true));
        }

        return ['session_id' => Session::get('cart_session_id')];
    }

    public function getCartItems()
    {
        $identifier = $this->getIdentifier();
        return CartItem::with(['product.primaryImage', 'product.category'])->where($identifier)->get();
    }

    public function add(Product $product, int $quantity = 1)
    {
        $identifier = $this->getIdentifier();
        
        $cartItem = CartItem::where($identifier)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
        } else {
            CartItem::create(array_merge($identifier, [
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]));
        }
    }

    public function update($cartItemId, int $quantity)
    {
        $cartItem = CartItem::find($cartItemId);
        if ($cartItem) {
            if ($quantity <= 0) {
                $cartItem->delete();
            } else {
                $cartItem->update(['quantity' => $quantity]);
            }
        }
    }

    public function remove($cartItemId)
    {
        CartItem::where('id', $cartItemId)->delete();
    }

    public function clear()
    {
        $identifier = $this->getIdentifier();
        CartItem::where($identifier)->delete();
    }

    public function getSubtotal()
    {
        $items = $this->getCartItems();
        return $items->sum(function ($item) {
            $price = $item->product->sale_price ?? $item->product->price;
            return $price * $item->quantity;
        });
    }

    public function getCount()
    {
        $identifier = $this->getIdentifier();
        return CartItem::where($identifier)->sum('quantity');
    }
}
