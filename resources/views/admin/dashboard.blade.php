<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - NestMart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800 antialiased font-sans flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-gray-200 min-h-screen p-6 hidden md:block">
        <h1 class="text-2xl font-extrabold text-emerald-600 mb-8">Nest Admin</h1>
        <nav class="space-y-3">
            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2.5 rounded-xl bg-emerald-50 text-emerald-600 font-bold">Dashboard</a>
            <a href="{{ route('admin.products.index') }}" class="block px-4 py-2.5 rounded-xl text-gray-600 hover:bg-gray-50 font-medium">Products</a>
            <a href="{{ route('admin.orders.index') }}" class="block px-4 py-2.5 rounded-xl text-gray-600 hover:bg-gray-50 font-medium">Orders</a>
            <a href="{{ route('admin.categories.index') }}" class="block px-4 py-2.5 rounded-xl text-gray-600 hover:bg-gray-50 font-medium">Categories</a>
            <a href="{{ route('home') }}" class="block px-4 py-2.5 rounded-xl text-gray-600 hover:bg-gray-50 font-medium">Storefront</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Dashboard Overview</h1>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                <span class="text-gray-500 text-sm font-medium">Total Revenue</span>
                <h3 class="text-3xl font-extrabold text-gray-900 mt-2">${{ number_format($totalRevenue, 2) }}</h3>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                <span class="text-gray-500 text-sm font-medium">Total Orders</span>
                <h3 class="text-3xl font-extrabold text-gray-900 mt-2">{{ $totalOrders }}</h3>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                <span class="text-gray-500 text-sm font-medium">Products</span>
                <h3 class="text-3xl font-extrabold text-gray-900 mt-2">{{ $totalProducts }}</h3>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                <span class="text-gray-500 text-sm font-medium">Users</span>
                <h3 class="text-3xl font-extrabold text-gray-900 mt-2">{{ $totalUsers }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Recent Orders</h3>
            <div class="overflow-x-auto">
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
                        @foreach($recentOrders as $order)
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
            </div>
        </div>
    </main>
</body>
</html>
