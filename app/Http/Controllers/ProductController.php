<?php

namespace App\Http\Controllers;

use App\Http\DTOs\ProductTabDTO;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['primaryImage', 'images', 'category', 'brand', 'reviews'])
            ->where('is_active', true);

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('brand')) {
            $brands = (array) $request->input('brand');
            $query->whereHas('brand', function ($q) use ($brands) {
                $q->whereIn('slug', $brands);
            });
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('min_price') || $request->filled('max_price')) {
            $min = $request->filled('min_price') ? (float) $request->min_price : 0;
            $max = $request->filled('max_price') ? (float) $request->max_price : 999999;
            $query->whereRaw('COALESCE(sale_price, price) BETWEEN ? AND ?', [$min, $max]);
        }

        switch ($request->get('sort')) {
            case 'price_low':
                $query->orderByRaw('COALESCE(sale_price, price) ASC');
                break;
            case 'price_high':
                $query->orderByRaw('COALESCE(sale_price, price) DESC');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'rating':
                $query->withAvg('reviews', 'rating')->orderByDesc('reviews_avg_rating');
                break;
            default:
                $query->orderByDesc('is_featured')->orderBy('id');
                break;
        }

        $perPage = match ($request->get('per_page')) {
            '24' => 24,
            '48' => 48,
            'all' => 1000,
            default => 12,
        };

        $products = $query->paginate($perPage)->withQueryString();
        $products->through(fn($product) => ProductTabDTO::fromModel($product));

        $categories = Category::where('is_active', true)->withCount('products')->orderBy('sort_order')->get();
        $brands = Brand::where('is_active', true)->withCount('products')->get();

        $currentCategory = $request->filled('category')
            ? Category::where('slug', $request->category)->where('is_active', true)->first()
            : null;

        $dealsOfDay = Product::with(['primaryImage', 'images', 'category', 'brand', 'reviews'])
            ->where('is_active', true)
            ->whereNotNull('sale_price')
            ->whereColumn('sale_price', '<', 'price')
            ->orderByDesc('created_at')
            ->take(4)
            ->get()
            ->map(fn($product, $index) => ProductTabDTO::fromModel($product, $index));

        $newProducts = Product::with(['primaryImage', 'images', 'category', 'brand', 'reviews'])
            ->where('is_active', true)
            ->orderByDesc('created_at')
            ->take(3)
            ->get()
            ->map(fn($product, $index) => ProductTabDTO::fromModel($product, $index));

        $priceLimit = (int) ceil(
            Product::where('is_active', true)->max(\Illuminate\Support\Facades\DB::raw('COALESCE(sale_price, price)')) ?? 100
        );

        return view('shop.index', compact(
            'products', 'categories', 'brands', 'currentCategory', 'dealsOfDay', 'newProducts', 'priceLimit'
        ));
    }

    public function show($slug)
    {
        $product = Product::with(['primaryImage', 'images', 'category', 'brand', 'variants', 'tags', 'reviews.user'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $relatedProducts = Product::with(['primaryImage', 'category'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('shop.show', compact('product', 'relatedProducts'));
    }

    public function quickview($slug)
    {
        $product = Product::with(['images', 'category', 'brand', 'reviews'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $images = $product->images->sortBy('sort_order')->values();
        $average = (float) $product->reviews->avg('rating');
        $reviewCount = $product->reviews->count();
        $salePrice = $product->sale_price;
        $hasDiscount = $salePrice && $salePrice < $product->price;

        return response()->json([
            'id'            => $product->id,
            'name'          => $product->name,
            'url'           => route('product.show', $product->slug),
            'category'      => $product->category?->name ?? '',
            'brand'         => $product->brand?->name ?? '',
            'price'         => $product->price,
            'sale_price'    => $salePrice,
            'has_discount'  => $hasDiscount,
            'discount_pct'  => $hasDiscount ? round((($product->price - $salePrice) / $product->price) * 100) : 0,
            'rating'        => round($average, 1),
            'rating_pct'    => $average * 20,
            'review_count'  => $reviewCount,
            'images'        => $images->map(fn($img) => asset($img->image_path))->values(),
            'sku'           => $product->sku,
        ]);
    }
}
