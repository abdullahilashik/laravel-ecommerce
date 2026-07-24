<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - NestMart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans">
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-emerald-600">NestMart</a>
            <a href="{{ route('cart.index') }}" class="text-gray-700 font-medium">Cart</a>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 grid grid-cols-1 md:grid-cols-4 gap-8">
        <!-- Sidebar -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 h-fit">
            <h3 class="font-bold text-lg mb-4">Categories</h3>
            <ul class="space-y-2 mb-8">
                <li><a href="{{ route('shop.index') }}" class="text-gray-600 hover:text-emerald-600">All Categories</a></li>
                @foreach($categories as $cat)
                    <li><a href="{{ route('shop.index', ['category' => $cat->slug]) }}" class="text-gray-600 hover:text-emerald-600 flex justify-between"><span>{{ $cat->name }}</span><span class="text-gray-400 text-xs">({{ $cat->products_count }})</span></a></li>
                @endforeach
            </ul>

            <h3 class="font-bold text-lg mb-4">Brands</h3>
            <ul class="space-y-2">
                @foreach($brands as $brand)
                    <li><a href="{{ route('shop.index', ['brand' => $brand->slug]) }}" class="text-gray-600 hover:text-emerald-600 flex justify-between"><span>{{ $brand->name }}</span><span class="text-gray-400 text-xs">({{ $brand->products_count }})</span></a></li>
                @endforeach
            </ul>
        </div>

        <!-- Products Grid -->
        <div class="md:col-span-3">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                @forelse($products as $product)
                    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex flex-col justify-between">
                        <div>
                            <div class="h-48 bg-gray-100 rounded-xl mb-4 overflow-hidden">
                                @if($product->primaryImage)
                                    <img src="{{ asset($product->primaryImage->image_path) }}" alt="{{ $product->name }}" class="object-cover h-full w-full">
                                @endif
                            </div>
                            <h3 class="font-bold text-gray-900 truncate"><a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a></h3>
                        </div>
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-lg font-bold text-emerald-600">${{ number_format($product->sale_price ?? $product->price, 2) }}</span>
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-emerald-600 text-white px-3 py-2 rounded-xl text-sm font-semibold hover:bg-emerald-700">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 col-span-3">No products available in this filter.</p>
                @endforelse
            </div>
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</body>
</html>
