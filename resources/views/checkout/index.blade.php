<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - NestMart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans">
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-emerald-600">NestMart</a>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Checkout</h1>

        <form action="{{ route('checkout.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @csrf
            <div class="lg:col-span-2 bg-white rounded-2xl p-8 shadow-sm border border-gray-100 space-y-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Billing & Shipping Details</h3>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" name="shipping_full_name" required value="{{ auth()->user()->name ?? '' }}" class="w-full border border-gray-300 rounded-xl px-4 py-3">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address Line 1</label>
                    <input type="text" name="shipping_address_line_1" required class="w-full border border-gray-300 rounded-xl px-4 py-3">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                        <input type="text" name="shipping_city" required class="w-full border border-gray-300 rounded-xl px-4 py-3">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">State</label>
                        <input type="text" name="shipping_state" required class="w-full border border-gray-300 rounded-xl px-4 py-3">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                        <input type="text" name="shipping_postal_code" required class="w-full border border-gray-300 rounded-xl px-4 py-3">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                        <input type="text" name="shipping_phone" required class="w-full border border-gray-300 rounded-xl px-4 py-3">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 h-fit space-y-4">
                <h3 class="font-bold text-lg mb-4">Order Summary</h3>
                @foreach($cartItems as $item)
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>{{ $item->product->name }} (x{{ $item->quantity }})</span>
                        <span>${{ number_format(($item->product->sale_price ?? $item->product->price) * $item->quantity, 2) }}</span>
                    </div>
                @endforeach
                <div class="pt-4 border-t border-gray-100 flex justify-between">
                    <span>Subtotal</span>
                    <span>${{ number_format($subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Shipping</span>
                    <span>${{ number_format($shippingCost, 2) }}</span>
                </div>
                <div class="pt-4 border-t border-gray-100 flex justify-between font-extrabold text-lg">
                    <span>Total</span>
                    <span class="text-emerald-600">${{ number_format($total, 2) }}</span>
                </div>

                <button type="submit" class="w-full bg-emerald-600 text-white py-4 rounded-xl font-bold shadow-lg hover:bg-emerald-700 transition mt-6">Place Order</button>
            </div>
        </form>
    </div>
</body>
</html>
