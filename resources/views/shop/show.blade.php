<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - NestMart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans">
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-emerald-600">NestMart</a>
            <a href="{{ route('cart.index') }}" class="text-gray-700 font-medium">Cart</a>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 grid grid-cols-1 md:grid-cols-2 gap-12">
            <div class="bg-gray-100 rounded-2xl h-96 flex items-center justify-center overflow-hidden">
                @if($product->primaryImage)
                    <img src="{{ asset($product->primaryImage->image_path) }}" alt="{{ $product->name }}" class="object-cover h-full w-full">
                @endif
            </div>
            <div>
                <span class="text-emerald-600 font-semibold uppercase text-sm">{{ $product->category->name ?? '' }}</span>
                <h1 class="text-3xl font-extrabold text-gray-900 mt-1 mb-4">{{ $product->name }}</h1>
                <div class="text-2xl font-bold text-emerald-600 mb-6">
                    ${{ number_format($product->sale_price ?? $product->price, 2) }}
                    @if($product->sale_price)
                        <span class="text-lg text-gray-400 line-through ml-2">${{ number_format($product->price, 2) }}</span>
                    @endif
                </div>
                <p class="text-gray-600 mb-8 leading-relaxed">{{ $product->description }}</p>

                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex items-center space-x-4">
                    @csrf
                    <input type="number" name="quantity" value="1" min="1" class="w-20 border border-gray-300 rounded-xl px-4 py-3 text-center">
                    <button type="submit" class="bg-emerald-600 text-white px-8 py-3.5 rounded-xl font-bold shadow-lg hover:bg-emerald-700 transition">Add to Cart</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
