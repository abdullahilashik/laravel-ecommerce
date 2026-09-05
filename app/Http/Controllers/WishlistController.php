<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $items = Auth::user()->wishlists()->with('product.primaryImage')->latest()->get();

        return view('wishlist.index', compact('items'));
    }

    public function toggle(Product $product)
    {
        $user = Auth::user();
        $existing = $user->wishlists()->where('product_id', $product->id)->first();

        if ($existing) {
            $existing->delete();
            $wishlisted = false;
            $message = 'Removed from wishlist.';
        } else {
            $user->wishlists()->create(['product_id' => $product->id]);
            $wishlisted = true;
            $message = 'Added to wishlist.';
        }

        return response()->json([
            'success' => true,
            'wishlisted' => $wishlisted,
            'count' => $user->wishlists()->count(),
            'message' => $message,
        ]);
    }

    public function remove(Product $product)
    {
        Auth::user()->wishlists()->where('product_id', $product->id)->delete();

        $count = Auth::user()->wishlists()->count();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'count' => $count,
                'message' => 'Removed from wishlist.',
            ]);
        }

        return back()->with('success', 'Removed from wishlist.');
    }
}