<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Management - Nest Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800 antialiased font-sans flex">
    <aside class="w-64 bg-white border-r border-gray-200 min-h-screen p-6 hidden md:block">
        <h1 class="text-2xl font-extrabold text-emerald-600 mb-8">Nest Admin</h1>
        <nav class="space-y-3">
            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2.5 rounded-xl text-gray-600 hover:bg-gray-50 font-medium">Dashboard</a>
            <a href="{{ route('admin.products.index') }}" class="block px-4 py-2.5 rounded-xl text-gray-600 hover:bg-gray-50 font-medium">Products</a>
            <a href="{{ route('admin.orders.index') }}" class="block px-4 py-2.5 rounded-xl bg-emerald-50 text-emerald-600 font-bold">Orders</a>
        </nav>
    </aside>

    <main class="flex-1 p-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Orders</h1>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100 text-gray-400 text-xs uppercase">
                        <th class="py-3 px-4">Order #</th>
                        <th class="py-3 px-4">Customer</th>
                        <th class="py-3 px-4">Total</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @foreach($orders as $order)
                        <tr>
                            <td class="py-3 px-4 font-bold">{{ $order->order_number }}</td>
                            <td class="py-3 px-4">{{ $order->user->name ?? 'Guest' }}</td>
                            <td class="py-3 px-4">${{ number_format($order->total_amount, 2) }}</td>
                            <td class="py-3 px-4"><span class="px-2.5 py-1 bg-emerald-50 text-emerald-600 rounded-full text-xs font-semibold uppercase">{{ $order->status }}</span></td>
                            <td class="py-3 px-4 text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        </div>
    </main>
</body>
</html>
