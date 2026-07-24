<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Nest Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800 antialiased font-sans flex">
    <aside class="w-64 bg-white border-r border-gray-200 min-h-screen p-6 hidden md:block">
        <h1 class="text-2xl font-extrabold text-emerald-600 mb-8">Nest Admin</h1>
        <nav class="space-y-3">
            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2.5 rounded-xl text-gray-600 hover:bg-gray-50 font-medium">Dashboard</a>
            <a href="{{ route('admin.products.index') }}" class="block px-4 py-2.5 rounded-xl bg-emerald-50 text-emerald-600 font-bold">Products</a>
        </nav>
    </aside>

    <main class="flex-1 p-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Add New Product</h1>

        <form action="{{ route('admin.products.store') }}" method="POST" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 space-y-6 max-w-2xl">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                <input type="text" name="name" required class="w-full border border-gray-300 rounded-xl px-4 py-3">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">SKU</label>
                    <input type="text" name="sku" required class="w-full border border-gray-300 rounded-xl px-4 py-3">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select name="category_id" required class="w-full border border-gray-300 rounded-xl px-4 py-3">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Price ($)</label>
                    <input type="number" step="0.01" name="price" required class="w-full border border-gray-300 rounded-xl px-4 py-3">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sale Price ($)</label>
                    <input type="number" step="0.01" name="sale_price" class="w-full border border-gray-300 rounded-xl px-4 py-3">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stock Quantity</label>
                    <input type="number" name="stock_quantity" required class="w-full border border-gray-300 rounded-xl px-4 py-3">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="4" required class="w-full border border-gray-300 rounded-xl px-4 py-3"></textarea>
            </div>
            <div class="flex items-center space-x-4">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="is_featured" value="1" class="rounded border-gray-300 text-emerald-600">
                    <span class="text-sm font-medium text-gray-700">Featured Product</span>
                </label>
            </div>
            <button type="submit" class="bg-emerald-600 text-white px-8 py-3.5 rounded-xl font-bold shadow-lg hover:bg-emerald-700 transition">Save Product</button>
        </form>
    </main>
</body>
</html>
