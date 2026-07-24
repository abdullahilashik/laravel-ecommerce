@props(['product' => null])

@if($product)
<div class="bg-white rounded-2xl p-4 shadow-sm hover:shadow-md transition border border-gray-100 flex flex-col justify-between group">
    <div>
        <div class="h-52 bg-gray-50 rounded-xl mb-4 flex items-center justify-center overflow-hidden relative">
            @if($product->badge)
                <span class="absolute top-3 left-3 text-white text-xs font-bold px-2.5 py-1 rounded-full z-10
                    {{ match($product->badge) {
                        'sale'  => 'bg-rose-500',
                        'hot'   => 'bg-amber-500',
                        'new'   => 'bg-emerald-500',
                        default => 'bg-blue-500',
                    } }}">
                    @if($product->badge === 'sale' && $product->hasDiscount())
                        -{{ $product->discountPercent() }}%
                    @else
                        {{ ucfirst($product->badge) }}
                    @endif
                </span>
            @endif

            <a href="{{ $product->url }}" class="block w-full h-full">
                @if($product->image)
                    <img
                        src="{{ $product->image }}"
                        alt="{{ $product->name }}"
                        class="object-cover h-full w-full group-hover:scale-105 transition duration-300"
                    >
                @else
                    <div class="flex items-center justify-center h-full text-gray-300">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
            </a>

            <div class="absolute top-3 right-3 flex flex-col space-y-2 opacity-0 group-hover:opacity-100 transition duration-200">
                <a aria-label="Add To Wishlist" class="action-btn w-8 h-8 bg-white rounded-full shadow flex items-center justify-center hover:bg-rose-50 hover:text-rose-500 text-gray-400 text-sm" href="#">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </a>
                <a aria-label="Compare" class="action-btn w-8 h-8 bg-white rounded-full shadow flex items-center justify-center hover:bg-blue-50 hover:text-blue-500 text-gray-400 text-sm" href="#">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </a>
                <a aria-label="Quick view" class="action-btn w-8 h-8 bg-white rounded-full shadow flex items-center justify-center hover:bg-emerald-50 hover:text-emerald-500 text-gray-400 text-sm" href="{{ $product->url }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </a>
            </div>
        </div>

        <span class="text-xs text-gray-400 uppercase font-semibold">
            <a href="{{ route('shop.index', ['category' => $product->categorySlug]) }}" class="hover:text-emerald-600">
                {{ $product->categoryName ?? 'Grocery' }}
            </a>
        </span>

        <h2 class="font-bold text-gray-900 mt-1 truncate">
            <a href="{{ $product->url }}" class="hover:text-emerald-600">{{ $product->name }}</a>
        </h2>

        <div class="flex items-center mt-1.5">
            <div class="flex items-center space-x-0.5">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= floor($product->averageRating))
                        <svg class="w-3.5 h-3.5 text-amber-400 fill-current" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    @elseif($i - $product->averageRating < 1 && $i - $product->averageRating > 0)
                        <svg class="w-3.5 h-3.5 text-amber-400 fill-current" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" style="clip-path: inset(0 {{ (1 - ($i - $product->averageRating)) * 100 }}% 0 0)"/></svg>
                    @else
                        <svg class="w-3.5 h-3.5 text-gray-200 fill-current" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    @endif
                @endfor
            </div>
            <span class="text-xs text-gray-400 ml-1.5">({{ $product->averageRating }})</span>
        </div>

        @if($product->brandName)
            <div class="mt-1">
                <span class="text-xs text-gray-400">By <a href="#" class="hover:text-emerald-600">{{ $product->brandName }}</a></span>
            </div>
        @endif
    </div>

    <div class="mt-3 flex items-center justify-between">
        <div>
            <span class="text-lg font-black text-emerald-600">${{ number_format($product->displayPrice(), 2) }}</span>
            @if($product->hasDiscount())
                <span class="text-sm text-gray-400 line-through ml-1">${{ number_format($product->price, 2) }}</span>
            @endif
        </div>
        <form action="{{ route('cart.add', $product->id) }}" method="POST">
            @csrf
            <button type="submit" class="bg-emerald-50 text-emerald-600 p-2.5 rounded-xl hover:bg-emerald-600 hover:text-white transition font-bold flex items-center text-sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                Add
            </button>
        </form>
    </div>
</div>
@endif
