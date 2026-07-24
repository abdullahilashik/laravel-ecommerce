<?php

namespace App\Http\Controllers;

use App\Http\DTOs\CategoryDTO;
use App\Http\DTOs\ProductTabDTO;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private const TAB_RELATIONS = ['primaryImage', 'images', 'category', 'brand', 'reviews'];

    public function index(\App\Services\CartService $cartService)
    {
        $sliders = Slider::where('is_active', true)->orderBy('sort_order')->get();

        $categories = Category::where('is_active', true)
                        ->withCount('products')
                        ->orderBy('sort_order')
                        ->get()
                        ->map(fn($category) => CategoryDTO::fromModel($category));

        $featuredProducts = Product::with(self::TAB_RELATIONS)
            ->where('is_featured', true)
            ->where('is_active', true)
            ->take(8)
            ->get();
        $popularProducts = Product::with(self::TAB_RELATIONS)
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

        $productTabs = $this->buildProductTabs($featuredProducts, $popularProducts);

        $cartCount = $cartService->getCount();

        return view('home', compact(
            'sliders', 'categories', 'featuredProducts', 'popularProducts',
            'bestSellers', 'dealsOfDay', 'cartCount', 'productTabs',
        ));
    }

    private function buildProductTabs($featuredProducts, $popularProducts): array
    {
        $allProducts = $featuredProducts->merge($popularProducts)->unique('id')->take(10)->values();

        $categoryTabs = $featuredProducts
            ->filter(fn($p) => $p->category)
            ->groupBy(fn($p) => $p->category->id)
            ->map(fn($products, $categoryId) => [
                'name'     => $products->first()->category->name,
                'id'       => 'tab-' . $products->first()->category->slug,
                'products' => ProductTabDTO::collection($products->take(10)),
            ])
            ->values()
            ->all();

        return array_merge([
            [
                'name'     => 'All',
                'id'       => 'tab-all',
                'products' => ProductTabDTO::collection($allProducts),
            ],
        ], $categoryTabs);
    }
}
