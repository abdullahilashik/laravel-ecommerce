<x-frontend title="Your Cart - Nest">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('home') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> Shop
                <span></span> Cart
            </div>
        </div>
    </div>
    <div class="container mb-80 mt-50">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="row">
            <div class="col-lg-8 mb-40">
                <h1 class="heading-2 mb-10">Your Cart</h1>
                <div class="d-flex justify-content-between">
                    <h6 class="text-body">There are <span class="text-brand">{{ $cartItems->sum('quantity') }}</span> products in your cart</h6>
                    <h6 class="text-body">
                        <form action="{{ route('cart.clear') }}" method="POST" class="d-inline" data-cart-clear>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-muted bg-transparent border-0 p-0"><i class="fi-rs-trash mr-5"></i>Clear Cart</button>
                        </form>
                    </h6>
                </div>
            </div>
        </div>

        @if($cartItems->isEmpty())
            <div class="row">
                <div class="col-12">
                    <div class="p-40 border border-radius-15 text-center">
                        <h4 class="mb-10">Your cart is empty</h4>
                        <p class="text-muted mb-30">Looks like you haven't added any products yet.</p>
                        <a href="{{ route('shop.index') }}" class="btn"><i class="fi-rs-arrow-left mr-10"></i>Continue Shopping</a>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-lg-8">
                    <div class="table-responsive shopping-summery">
                        <table class="table table-wishlist">
                            <thead>
                                <tr class="main-heading">
                                    <th scope="col" colspan="2">Product</th>
                                    <th scope="col">Unit Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Subtotal</th>
                                    <th scope="col" class="end">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $item)
                                    @php
                                        $unitPrice = $item->product->sale_price ?? $item->product->price;
                                    @endphp
                                    <tr>
                                        <td class="image product-thumbnail">
                                            <a href="{{ route('product.show', $item->product->slug) }}">
                                                @if($item->product->primaryImage)
                                                    <img src="{{ asset($item->product->primaryImage->image_path) }}" alt="{{ $item->product->name }}">
                                                @endif
                                            </a>
                                        </td>
                                        <td class="product-des product-name">
                                            <h6 class="mb-5"><a class="product-name mb-10 text-heading" href="{{ route('product.show', $item->product->slug) }}">{{ $item->product->name }}</a></h6>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                        </td>
                                        <td class="price" data-title="Price">
                                            <h4 class="text-body">${{ number_format($unitPrice, 2) }}</h4>
                                        </td>
                                        <td class="text-center detail-info" data-title="Stock">
                                            <div class="detail-extralink mr-15">
                                                <div class="detail-qty border radius">
                                                    <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                                    <input type="text" name="quantities[{{ $item->id }}]" form="cart-update-form" class="qty-val" value="{{ $item->quantity }}" min="1">
                                                    <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="price" data-title="Price">
                                            <h4 class="text-brand">${{ number_format($unitPrice * $item->quantity, 2) }}</h4>
                                        </td>
                                        <td class="action text-center" data-title="Remove">
                                            <form action="{{ route('cart.remove', $item->id) }}" method="POST" data-cart-remove>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-body btn p-0"><i class="fi-rs-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <form id="cart-update-form" action="{{ route('cart.updateAll') }}" method="POST">
                        @csrf
                        @method('PUT')
                    </form>
                    <div class="divider-2 mb-30"></div>
                    <div class="cart-action d-flex justify-content-between">
                        <a class="btn" href="{{ route('shop.index') }}"><i class="fi-rs-arrow-left mr-10"></i>Continue Shopping</a>
                        <button type="submit" form="cart-update-form" class="btn mr-10 mb-sm-15"><i class="fi-rs-refresh mr-10"></i>Update Cart</button>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="border p-md-4 cart-totals ml-30">
                        <div class="table-responsive">
                            <table class="table no-border">
                                <tbody>
                                    <tr>
                                        <td class="cart_total_label">
                                            <h6 class="text-muted">Subtotal</h6>
                                        </td>
                                        <td class="cart_total_amount">
                                            <h4 class="text-brand text-end">${{ number_format($subtotal, 2) }}</h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="col" colspan="2">
                                            <div class="divider-2 mt-10 mb-10"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="cart_total_label">
                                            <h6 class="text-muted">Shipping</h6>
                                        </td>
                                        <td class="cart_total_amount">
                                            <h5 class="text-heading text-end">${{ number_format($shippingCost, 2) }}</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="cart_total_label">
                                            <h6 class="text-muted">Tax (5%)</h6>
                                        </td>
                                        <td class="cart_total_amount">
                                            <h5 class="text-heading text-end">${{ number_format($taxAmount, 2) }}</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="col" colspan="2">
                                            <div class="divider-2 mt-10 mb-10"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="cart_total_label">
                                            <h6 class="text-muted">Total</h6>
                                        </td>
                                        <td class="cart_total_amount">
                                            <h4 class="text-brand text-end">${{ number_format($total, 2) }}</h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <a href="{{ route('checkout.show') }}" class="btn mb-20 w-100">Proceed To CheckOut<i class="fi-rs-sign-out ml-15"></i></a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-frontend>