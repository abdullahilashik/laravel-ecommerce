<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['primaryImage', 'category', 'brand'])->where('is_active', true);

        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->has('brand')) {
            $query->whereHas('brand', function ($q) use ($request) {
                $q->where('slug', $request->brand);
            });
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::where('is_active', true)->withCount('products')->get();
        $brands = Brand::where('is_active', true)->withCount('products')->get();

        return view('shop.index', compact('products', 'categories', 'brands'));
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
