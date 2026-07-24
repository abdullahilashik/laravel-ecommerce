<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Management - Nest Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800 antialiased font-sans flex">
    <aside class="w-64 bg-white border-r border-gray-200 min-h-screen p-6 hidden md:block">
        <h1 class="text-2xl font-extrabold text-emerald-600 mb-8">Nest Admin</h1>
        <nav class="space-y-3">
            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2.5 rounded-xl text-gray-600 hover:bg-gray-50 font-medium">Dashboard</a>
            <a href="{{ route('admin.products.index') }}" class="block px-4 py-2.5 rounded-xl bg-emerald-50 text-emerald-600 font-bold">Products</a>
            <a href="{{ route('admin.orders.index') }}" class="block px-4 py-2.5 rounded-xl text-gray-600 hover:bg-gray-50 font-medium">Orders</a>
            <a href="{{ route('admin.categories.index') }}" class="block px-4 py-2.5 rounded-xl text-gray-600 hover:bg-gray-50 font-medium">Categories</a>
        </nav>
    </aside>

    <main class="flex-1 p-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900">Products</h1>
            <a href="{{ route('admin.products.create') }}" class="bg-emerald-600 text-white px-5 py-2.5 rounded-xl font-bold hover:bg-emerald-700">Add New Product</a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100 text-gray-400 text-xs uppercase">
                        <th class="py-3 px-4">Name</th>
                        <th class="py-3 px-4">SKU</th>
                        <th class="py-3 px-4">Category</th>
                        <th class="py-3 px-4">Price</th>
                        <th class="py-3 px-4">Stock</th>
                        <th class="py-3 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @foreach($products as $product)
                        <tr>
                            <td class="py-3 px-4 font-bold">{{ $product->name }}</td>
                            <td class="py-3 px-4 text-gray-500">{{ $product->sku }}</td>
                            <td class="py-3 px-4">{{ $product->category->name ?? 'N/A' }}</td>
                            <td class="py-3 px-4">${{ number_format($product->price, 2) }}</td>
                            <td class="py-3 px-4">{{ $product->stock_quantity }}</td>
                            <td class="py-3 px-4">
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </div>
    </main>
</body>
</html>
