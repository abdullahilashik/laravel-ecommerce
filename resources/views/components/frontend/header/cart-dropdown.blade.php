@props([
    'cartItems' => collect(),
    'cartSubtotal' => 0,
    'prefix' => 'd',
])

<ul>
    @forelse ($cartItems as $item)
        <li>
            <div class="shopping-cart-img">
                <a href="{{ route('product.show', $item->product->slug) }}">
                    @if ($item->product->primaryImage)
                        <img alt="{{ $item->product->name }}" src="{{ asset($item->product->primaryImage->image_path) }}" />
                    @endif
                </a>
            </div>
            <div class="shopping-cart-title">
                <h4><a href="{{ route('product.show', $item->product->slug) }}">{{ $item->product->name }}</a></h4>
                <h4><span>{{ $item->quantity }} × </span>${{ number_format($item->product->sale_price ?? $item->product->price, 2) }}</h4>
            </div>
            <div class="shopping-cart-delete">
                <a href="#" onclick="event.preventDefault(); document.getElementById('remove-cart-{{ $prefix }}-{{ $item->id }}').submit();"><i class="fi-rs-cross-small"></i></a>
                <form id="remove-cart-{{ $prefix }}-{{ $item->id }}" action="{{ route('cart.remove', $item->id) }}" method="POST" class="d-none" data-cart-remove>@csrf @method('DELETE')</form>
            </div>
        </li>
    @empty
        <li>
            <div class="shopping-cart-title">
                <h4>Your cart is empty</h4>
            </div>
        </li>
    @endforelse
</ul>
<div class="shopping-cart-footer">
    <div class="shopping-cart-total">
        <h4>Total <span>${{ number_format($cartSubtotal, 2) }}</span></h4>
    </div>
    <div class="shopping-cart-button">
        <a href="{{ route('cart.index') }}" class="outline">View cart</a>
        <a href="{{ route('checkout.show') }}">Checkout</a>
    </div>
</div>