<x-frontend title="Wishlist - Nest">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('home') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> Shop
                <span></span> Wishlist
            </div>
        </div>
    </div>
    <div class="container mb-80 mt-50">
        @if(session('success'))
            <div class="alert alert-success mb-30">{{ session('success') }}</div>
        @endif
        <div class="row">
            <div class="col-xl-10 col-lg-12 m-auto">
                <div class="mb-50">
                    <h1 class="heading-2 mb-10">Your Wishlist</h1>
                    <h6 class="text-body">There are <span class="text-brand">{{ $items->count() }}</span> products in this list</h6>
                </div>

                @if($items->isEmpty())
                    <div class="p-40 border border-radius-15 text-center">
                        <h4 class="mb-10">Your wishlist is empty</h4>
                        <p class="text-muted mb-30">Looks like you haven't added any products yet.</p>
                        <a href="{{ route('shop.index') }}" class="btn"><i class="fi-rs-arrow-left mr-10"></i>Continue Shopping</a>
                    </div>
                @else
                    <div class="table-responsive shopping-summery">
                        <table class="table table-wishlist">
                            <thead>
                                <tr class="main-heading">
                                    <th scope="col" colspan="2">Product</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Stock Status</th>
                                    <th scope="col">Action</th>
                                    <th scope="col" class="end">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                    @php
                                        $product = $item->product;
                                        $image = $product->primaryImage?->image_path ? asset($product->primaryImage->image_path) : asset('assets/imgs/shop/thumbnail-3.jpg');
                                        $price = $product->sale_price ?? $product->price;
                                        $inStock = $product->stock_quantity > 0;
                                    @endphp
                                    <tr class="pt-30">
                                        <td class="image product-thumbnail pt-40">
                                            <a href="{{ route('product.show', $product->slug) }}">
                                                <img src="{{ $image }}" alt="{{ $product->name }}" />
                                            </a>
                                        </td>
                                        <td class="product-des product-name">
                                            <h6><a class="product-name mb-10" href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a></h6>
                                        </td>
                                        <td class="price" data-title="Price">
                                            <h3 class="text-brand">${{ number_format($price, 2) }}</h3>
                                        </td>
                                        <td class="text-center detail-info" data-title="Stock">
                                            @if($inStock)
                                                <span class="stock-status in-stock mb-0">In Stock</span>
                                            @else
                                                <span class="stock-status out-stock mb-0">Out of Stock</span>
                                            @endif
                                        </td>
                                        <td class="text-right" data-title="Cart">
                                            @if($inStock)
                                                <button type="button" class="btn btn-sm" data-cart-add-product="{{ $product->id }}">
                                                    <i class="fi-rs-shopping-cart mr-5"></i>Add to cart
                                                </button>
                                            @else
                                                <button class="btn btn-sm btn-secondary" disabled>Contact Us</button>
                                            @endif
                                        </td>
                                        <td class="action text-center" data-title="Remove">
                                            <form action="{{ route('wishlist.remove', $product->id) }}" method="POST" class="d-inline" data-wishlist-remove>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-body bg-transparent border-0 p-0"><i class="fi-rs-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-30">
                        <a href="{{ route('shop.index') }}" class="btn"><i class="fi-rs-arrow-left mr-10"></i>Continue Shopping</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-frontend>