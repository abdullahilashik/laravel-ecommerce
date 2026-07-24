<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nest 2 - Multipurpose eCommerce Marketplace</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-800 antialiased font-sans">

    <!-- Top Header Bar -->
    <div class="border-b border-gray-200 text-xs text-gray-500 py-2 hidden lg:block">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <div class="flex space-x-6">
                <a href="#" class="hover:text-emerald-600">About Us</a>
                <a href="{{ route('account.index') }}" class="hover:text-emerald-600">My Account</a>
                <a href="#" class="hover:text-emerald-600">Wishlist</a>
                <a href="#" class="hover:text-emerald-600">Order Tracking</a>
            </div>
            <div>
                <span>100% Secure delivery without contacting the courier</span>
            </div>
            <div class="flex space-x-4">
                <span>Need help? Call Us: <strong class="text-emerald-600">+1800 900</strong></span>
                <span class="border-l border-gray-200 pl-4">English</span>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header class="bg-white sticky top-0 z-50 border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-24 flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center space-x-12">
                <a href="{{ route('home') }}" class="text-3xl font-black text-emerald-600 tracking-tight flex items-center">
                    <span class="mr-1">🌱</span> Nest<span class="text-amber-500">Mart</span>
                </a>
            </div>

            <!-- Search Bar -->
            <div class="hidden md:flex flex-1 max-w-2xl mx-12">
                <form action="{{ route('shop.index') }}" method="GET" class="flex w-full border-2 border-emerald-500 rounded-xl overflow-hidden shadow-sm">
                    <select name="category" class="bg-gray-50 border-r border-gray-200 text-sm px-4 py-3 text-gray-700 outline-none hidden lg:block">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->slug }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="search" placeholder="Search for items..." class="flex-1 px-4 py-3 text-sm outline-none">
                    <button type="submit" class="bg-emerald-600 text-white px-6 font-semibold flex items-center justify-center hover:bg-emerald-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </form>
            </div>

            <!-- Header Actions -->
            <div class="flex items-center space-x-6">
                <a href="{{ route('cart.index') }}" class="relative flex items-center text-gray-700 hover:text-emerald-600">
                    <div class="relative">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        <span class="absolute -top-2 -right-2 bg-emerald-600 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center font-bold">{{ $cartCount ?? 0 }}</span>
                    </div>
                    <span class="ml-2 font-bold hidden sm:inline">Cart</span>
                </a>

                @auth
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('dashboard') }}" class="font-bold text-gray-800 hover:text-emerald-600">{{ auth()->user()->name }}</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-red-500 hover:underline">Logout</button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="flex items-center text-gray-700 hover:text-emerald-600 font-bold">
                        <svg class="w-6 h-6 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Account
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Navigation Menu Bar -->
    <nav class="border-b border-gray-200 hidden md:block bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-14">
            <div class="flex items-center space-x-8">
                <div class="bg-emerald-600 text-white px-6 py-3 rounded-xl font-bold flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    <span>Browse All Categories</span>
                </div>
                <ul class="flex space-x-8 font-bold text-gray-700">
                    <li><a href="{{ route('home') }}" class="text-emerald-600 hover:text-emerald-700">Home</a></li>
                    <li><a href="{{ route('shop.index') }}" class="hover:text-emerald-600">Shop</a></li>
                    <li><a href="{{ route('shop.index') }}" class="hover:text-emerald-600">Vendors</a></li>
                    <li><a href="{{ route('shop.index') }}" class="hover:text-emerald-600">Blog</a></li>
                    <li><a href="{{ route('shop.index') }}" class="hover:text-emerald-600">Contact</a></li>
                </ul>
            </div>
            <div class="flex items-center space-x-2 text-emerald-600 font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                <span class="text-xl">1900 - 888</span>
            </div>
        </div>
    </nav>

    <!-- Hero Slider Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-emerald-50 rounded-3xl p-8 md:p-16 flex flex-col md:flex-row items-center justify-between relative overflow-hidden shadow-sm">
            <div class="max-w-xl z-10">
                <span class="text-emerald-600 font-bold uppercase tracking-wider text-sm bg-emerald-100 px-3 py-1 rounded-full">Fresh & Natural</span>
                <h1 class="text-4xl md:text-6xl font-extrabold text-gray-900 mt-4 mb-6 leading-tight">Don't miss our daily amazing deals</h1>
                <p class="text-gray-600 mb-8 text-lg">Save up to 50% off on your first order. Free delivery on orders over $50.</p>
                <form action="#" class="flex bg-white rounded-full overflow-hidden shadow-md max-w-md p-1">
                    <input type="email" placeholder="Your emaill address" class="flex-1 px-4 py-3 outline-none text-sm">
                    <button type="submit" class="bg-emerald-600 text-white px-8 py-3 rounded-full font-bold hover:bg-emerald-700">Subscribe</button>
                </form>
            </div>
            <div class="mt-8 md:mt-0 z-10">
                <div class="w-72 h-72 md:w-96 md:h-96 bg-emerald-200/50 rounded-full flex items-center justify-center text-emerald-800 text-6xl shadow-inner">
                    🍎🥦
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Categories Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-black text-gray-900">Featured Categories</h2>
            <div class="flex space-x-2">
                <button class="w-10 h-10 rounded-full bg-gray-100 hover:bg-emerald-600 hover:text-white flex items-center justify-center font-bold">&larr;</button>
                <button class="w-10 h-10 rounded-full bg-gray-100 hover:bg-emerald-600 hover:text-white flex items-center justify-center font-bold">&rarr;</button>
            </div>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-6">
            @foreach($categories as $cat)
                <a href="{{ route('shop.index', ['category' => $cat->slug]) }}" class="bg-emerald-50/50 hover:bg-emerald-100/60 p-6 rounded-2xl text-center transition border border-emerald-100 group">
                    <div class="w-20 h-20 bg-white rounded-full mx-auto mb-4 flex items-center justify-center shadow-sm text-2xl group-hover:scale-110 transition">
                        🛒
                    </div>
                    <h3 class="font-bold text-gray-800 group-hover:text-emerald-600">{{ $cat->name }}</h3>
                    <span class="text-xs text-gray-400 mt-1 block">{{ $cat->products_count }} items</span>
                </a>
            @endforeach
        </div>
    </section>

    <!-- Banner Ads Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-amber-50 rounded-3xl p-8 flex flex-col justify-between border border-amber-100">
                <div>
                    <span class="text-xs font-bold text-amber-600 uppercase">Everyday Fresh</span>
                    <h3 class="text-2xl font-black text-gray-900 mt-1 mb-4">Organic Vegetables & Fruits</h3>
                    <a href="{{ route('shop.index') }}" class="bg-emerald-600 text-white px-4 py-2 rounded-xl text-sm font-bold inline-block hover:bg-emerald-700">Shop Now &rarr;</a>
                </div>
            </div>
            <div class="bg-emerald-50 rounded-3xl p-8 flex flex-col justify-between border border-emerald-100">
                <div>
                    <span class="text-xs font-bold text-emerald-600 uppercase">Free Delivery</span>
                    <h3 class="text-2xl font-black text-gray-900 mt-1 mb-4">Fresh Organic Breakfast Box</h3>
                    <a href="{{ route('shop.index') }}" class="bg-emerald-600 text-white px-4 py-2 rounded-xl text-sm font-bold inline-block hover:bg-emerald-700">Shop Now &rarr;</a>
                </div>
            </div>
            <div class="bg-rose-50 rounded-3xl p-8 flex flex-col justify-between border border-rose-100">
                <div>
                    <span class="text-xs font-bold text-rose-600 uppercase">100% Organic</span>
                    <h3 class="text-2xl font-black text-gray-900 mt-1 mb-4">Best Organic Teas & Coffees</h3>
                    <a href="{{ route('shop.index') }}" class="bg-emerald-600 text-white px-4 py-2 rounded-xl text-sm font-bold inline-block hover:bg-emerald-700">Shop Now &rarr;</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-black text-gray-900">Popular Products</h2>
            <div class="flex space-x-6 font-bold text-gray-500">
                <a href="#" class="text-emerald-600 border-b-2 border-emerald-600 pb-1">All</a>
                <a href="#" class="hover:text-emerald-600">Milks & Dairies</a>
                <a href="#" class="hover:text-emerald-600">Coffees</a>
                <a href="#" class="hover:text-emerald-600">Pet Foods</a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
                <div class="bg-white rounded-2xl p-4 shadow-sm hover:shadow-md transition border border-gray-100 flex flex-col justify-between group">
                    <div>
                        <div class="h-52 bg-gray-50 rounded-xl mb-4 flex items-center justify-center overflow-hidden relative">
                            @if($product->sale_price)
                                <span class="absolute top-3 left-3 bg-rose-500 text-white text-xs font-bold px-2.5 py-1 rounded-full">Sale</span>
                            @endif
                            @if($product->primaryImage)
                                <img src="{{ asset($product->primaryImage->image_path) }}" alt="{{ $product->name }}" class="object-cover h-full w-full group-hover:scale-105 transition">
                            @else
                                <span class="text-gray-400">No Image</span>
                            @endif
                        </div>
                        <span class="text-xs text-gray-400 uppercase font-semibold">{{ $product->category->name ?? 'Grocery' }}</span>
                        <h3 class="font-bold text-gray-900 mt-1 truncate"><a href="{{ route('product.show', $product->slug) }}" class="hover:text-emerald-600">{{ $product->name }}</a></h3>
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <div>
                            <span class="text-xl font-black text-emerald-600">${{ number_format($product->sale_price ?? $product->price, 2) }}</span>
                            @if($product->sale_price)
                                <span class="text-sm text-gray-400 line-through ml-1">${{ number_format($product->price, 2) }}</span>
                            @endif
                        </div>
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-emerald-50 text-emerald-600 p-3 rounded-xl hover:bg-emerald-600 hover:text-white transition font-bold flex items-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Best Sellers Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-black text-gray-900">Daily Best Sells</h2>
            <div class="flex space-x-6 font-bold text-gray-500">
                <a href="#" class="text-emerald-600 border-b-2 border-emerald-600 pb-1">Featured</a>
                <a href="#" class="hover:text-emerald-600">Popular</a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($bestSellers as $product)
                <div class="bg-white rounded-2xl p-4 shadow-sm hover:shadow-md transition border border-gray-100 flex flex-col justify-between">
                    <div>
                        <div class="h-48 bg-gray-50 rounded-xl mb-4 overflow-hidden">
                            @if($product->primaryImage)
                                <img src="{{ asset($product->primaryImage->image_path) }}" alt="{{ $product->name }}" class="object-cover h-full w-full">
                            @endif
                        </div>
                        <span class="text-xs text-gray-400 uppercase font-semibold">{{ $product->category->name ?? '' }}</span>
                        <h3 class="font-bold text-gray-900 mt-1 truncate"><a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a></h3>
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-lg font-bold text-emerald-600">${{ number_format($product->sale_price ?? $product->price, 2) }}</span>
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-emerald-700">Add</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Features Footer Banner -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-6">
            <div class="bg-gray-50 p-6 rounded-2xl flex items-center space-x-4">
                <div class="text-3xl">📦</div>
                <div><h4 class="font-bold text-gray-900">Best prices & offers</h4><p class="text-xs text-gray-500">Orders $50 or more</p></div>
            </div>
            <div class="bg-gray-50 p-6 rounded-2xl flex items-center space-x-4">
                <div class="text-3xl">🚚</div>
                <div><h4 class="font-bold text-gray-900">Free delivery</h4><p class="text-xs text-gray-500">24/7 amazing services</p></div>
            </div>
            <div class="bg-gray-50 p-6 rounded-2xl flex items-center space-x-4">
                <div class="text-3xl">🌿</div>
                <div><h4 class="font-bold text-gray-900">Great daily deal</h4><p class="text-xs text-gray-500">When you sign up</p></div>
            </div>
            <div class="bg-gray-50 p-6 rounded-2xl flex items-center space-x-4">
                <div class="text-3xl">🏷️</div>
                <div><h4 class="font-bold text-gray-900">Wide assortment</h4><p class="text-xs text-gray-500">Mega Discounts</p></div>
            </div>
            <div class="bg-gray-50 p-6 rounded-2xl flex items-center space-x-4">
                <div class="text-3xl">🔄</div>
                <div><h4 class="font-bold text-gray-900">Easy returns</h4><p class="text-xs text-gray-500">Within 30 days</p></div>
            </div>
        </div>
    </section>

    <!-- Comprehensive Footer -->
    <footer class="bg-white border-t border-gray-200 mt-16 pt-16 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-5 gap-8 mb-12">
            <div class="md:col-span-1">
                <a href="{{ route('home') }}" class="text-2xl font-black text-emerald-600 tracking-tight flex items-center mb-4">
                    <span class="mr-1">🌱</span> Nest<span class="text-amber-500">Mart</span>
                </a>
                <p class="text-gray-500 text-sm mb-4">Awesome grocery store template & ecommerce marketplace.</p>
                <p class="text-sm text-gray-700 mb-2"><strong>Address:</strong> 5171 W Campbell Ave undefined Kent, Utah 53165 United States</p>
                <p class="text-sm text-gray-700 mb-2"><strong>Call Us:</strong> (+91) - 540-025-124553</p>
                <p class="text-sm text-gray-700"><strong>Email:</strong> sale@NestMart.com</p>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 mb-4 text-lg">Company</h4>
                <ul class="space-y-3 text-sm text-gray-600">
                    <li><a href="#" class="hover:text-emerald-600">About Us</a></li>
                    <li><a href="#" class="hover:text-emerald-600">Delivery Information</a></li>
                    <li><a href="#" class="hover:text-emerald-600">Privacy Policy</a></li>
                    <li><a href="#" class="hover:text-emerald-600">Terms & Conditions</a></li>
                    <li><a href="#" class="hover:text-emerald-600">Contact Us</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 mb-4 text-lg">Account</h4>
                <ul class="space-y-3 text-sm text-gray-600">
                    <li><a href="{{ route('login') }}" class="hover:text-emerald-600">Sign In</a></li>
                    <li><a href="{{ route('cart.index') }}" class="hover:text-emerald-600">View Cart</a></li>
                    <li><a href="#" class="hover:text-emerald-600">My Wishlist</a></li>
                    <li><a href="#" class="hover:text-emerald-600">Track My Order</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 mb-4 text-lg">Corporate</h4>
                <ul class="space-y-3 text-sm text-gray-600">
                    <li><a href="#" class="hover:text-emerald-600">Become a Vendor</a></li>
                    <li><a href="#" class="hover:text-emerald-600">Affiliate Program</a></li>
                    <li><a href="#" class="hover:text-emerald-600">Farm Business</a></li>
                    <li><a href="#" class="hover:text-emerald-600">Farm Careers</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 mb-4 text-lg">Install App</h4>
                <p class="text-xs text-gray-500 mb-4">From App Store or Google Play</p>
                <div class="space-y-2">
                    <div class="bg-gray-900 text-white px-4 py-2 rounded-xl text-xs font-bold inline-block">App Store / Google Play</div>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 border-t border-gray-100 flex flex-col md:flex-row items-center justify-between text-xs text-gray-400">
            <p>&copy; 2026 NestMart - All rights reserved.</p>
            <p>Designed with Tailwind CSS & Laravel 13.</p>
        </div>
    </footer>
</body>
</html>
