<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - NestMart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans">
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-emerald-600">NestMart</a>
        </div>
    </header>

    <div class="max-w-3xl mx-auto px-4 py-16 text-center">
        <div class="bg-white rounded-3xl p-10 shadow-sm border border-gray-100">
            <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-4xl mx-auto mb-6">✓</div>
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Thank You for Your Order!</h1>
            <p class="text-gray-600 mb-6">Your order number is <span class="font-bold text-gray-900">{{ $order->order_number }}</span></p>
            <div class="bg-gray-50 rounded-2xl p-6 text-left mb-8 space-y-2">
                <div class="flex justify-between"><span class="text-gray-500">Status:</span><span class="font-bold text-emerald-600 uppercase">{{ $order->status }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Total Amount:</span><span class="font-bold">${{ number_format($order->total_amount, 2) }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Payment Method:</span><span class="font-bold uppercase">{{ $order->payment_method }}</span></div>
            </div>
            <a href="{{ route('home') }}" class="bg-emerald-600 text-white px-8 py-3.5 rounded-xl font-bold hover:bg-emerald-700 transition">Return to Home</a>
        </div>
    </div>
</body>
</html>
