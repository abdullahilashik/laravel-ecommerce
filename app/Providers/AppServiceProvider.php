<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Wishlist;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(CartService $cartService): void
    {
        View::composer('components.frontend.header', function ($view) use ($cartService) {
            $categories = Category::where('is_active', true)
                ->withCount('products')
                ->orderBy('sort_order')
                ->get();

            $view->with([
                'categories' => $categories,
                'cartItems' => $cartService->getCartItems(),
                'cartSubtotal' => $cartService->getSubtotal(),
                'cartCount' => $cartService->getCount(),
                'wishlistCount' => Auth::check() ? Wishlist::where('user_id', Auth::id())->count() : 0,
            ]);
        });
    }
}
