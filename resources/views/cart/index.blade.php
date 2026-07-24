<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - NestMart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans">
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-emerald-600">NestMart</a>
            <a href="{{ route('shop.index') }}" class="text-gray-700 font-medium">Continue Shopping</a>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Your Shopping Cart</h1>

        @if($cartItems->isEmpty())
            <div class="bg-white rounded-2xl p-12 text-center shadow-sm">
                <p class="text-gray-500 text-lg mb-6">Your cart is empty.</p>
                <a href="{{ route('shop.index') }}" class="bg-emerald-600 text-white px-6 py-3 rounded-xl font-bold">Start Shopping</a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cartItems as $item)
                        <div class="bg-white rounded-2xl p-4 shadow-sm flex items-center justify-between border border-gray-100">
                            <div class="flex items-center space-x-4">
                                <div class="w-20 h-20 bg-gray-100 rounded-xl overflow-hidden">
                                    @if($item->product->primaryImage)
                                        <img src="{{ asset($item->product->primaryImage->image_path) }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900">{{ $item->product->name }}</h3>
                                    <span class="text-emerald-600 font-semibold">${{ number_format($item->product->sale_price ?? $item->product->price, 2) }}</span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4">
                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" onchange="this.form.submit()" class="w-16 border rounded-lg text-center py-1">
                                </form>
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-semibold">Remove</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 h-fit">
                    <h3 class="font-bold text-lg mb-4">Cart Totals</h3>
                    <div class="flex justify-between mb-4 pb-4 border-b border-gray-100">
                        <span>Subtotal</span>
                        <span class="font-bold">${{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between mb-6">
                        <span class="font-bold text-lg">Total</span>
                        <span class="font-extrabold text-xl text-emerald-600">${{ number_format($subtotal, 2) }}</span>
                    </div>
                    <a href="{{ route('checkout.show') }}" class="block text-center bg-emerald-600 text-white py-4 rounded-xl font-bold shadow-lg hover:bg-emerald-700 transition">Proceed to Checkout</a>
                </div>
            </div>
        @endif
    </div>
</body>
</html>
