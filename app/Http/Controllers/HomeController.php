<?php

namespace App\Http\Controllers;

use App\Http\DTOs\CategoryDTO;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(\App\Services\CartService $cartService)
    {
        $sliders = Slider::where('is_active', true)->orderBy('sort_order')->get();

        $categories = Category::where('is_active', true)
                        ->withCount('products')
                        ->orderBy('sort_order')
                        ->get()
                        ->map(fn($category) => CategoryDTO::fromModel($category));

        $featuredProducts = Product::with(['primaryImage', 'category', 'brand'])
            ->where('is_featured', true)
            ->where('is_active', true)
            ->take(8)
            ->get();
        $popularProducts = Product::with(['primaryImage', 'category', 'brand'])
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();
        $bestSellers = Product::with(['primaryImage', 'category', 'brand'])
            ->where('is_active', true)
            ->inRandomOrder()
            ->take(4)
            ->get();
        $dealsOfDay = Product::with(['primaryImage', 'category', 'brand'])
            ->where('is_active', true)
            ->whereNotNull('sale_price')
            ->take(4)
            ->get();

        $cartCount = $cartService->getCount();

        // dd($categories);

        return view('home', compact('sliders', 'categories', 'featuredProducts', 'popularProducts', 'bestSellers', 'dealsOfDay', 'cartCount'));
    }
}
