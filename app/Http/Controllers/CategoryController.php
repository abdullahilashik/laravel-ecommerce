<?php

namespace App\Http\Controllers;

use App\Http\DTOs\ProductTabDTO;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function show($slug, Request $request)
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $categoryIds = collect([$category->id])
            ->merge($category->children()->where('is_active', true)->pluck('id'))
            ->all();

        $query = Product::with(['primaryImage', 'images', 'category', 'brand', 'reviews'])
            ->where('is_active', true)
            ->whereIn('category_id', $categoryIds);

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

        $newProducts = Product::with(['primaryImage', 'images', 'category', 'brand', 'reviews'])
            ->where('is_active', true)
            ->orderByDesc('created_at')
            ->take(3)
            ->get()
            ->map(fn($product, $index) => ProductTabDTO::fromModel($product, $index));

        $priceLimit = (int) ceil(
            Product::where('is_active', true)
                ->whereIn('category_id', $categoryIds)
                ->max(DB::raw('COALESCE(sale_price, price)')) ?? 100
        );

        return view('category.show', compact(
            'category', 'products', 'categories', 'brands', 'newProducts', 'priceLimit'
        ));
    }
}