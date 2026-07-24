@props([
    'tabs' => [],
    'title' => 'Popular Products',
])

@php
    $activeTabs = collect($tabs)->filter(fn($tab) => count($tab['products']) > 0)->values();
@endphp

@if($activeTabs->isNotEmpty())
<section class="product-tabs section-padding position-relative">
    <div class="container">
        <div class="section-title style-2 wow animate__animated animate__fadeIn">
            <h3>{{ $title }}</h3>
            <ul class="nav nav-tabs links" id="myTab" role="tablist">
                @foreach($activeTabs as $index => $tab)
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link {{ $index === 0 ? 'active' : '' }}"
                            id="nav-{{ $tab['id'] }}"
                            data-bs-toggle="tab"
                            data-bs-target="#{{ $tab['id'] }}"
                            type="button"
                            role="tab"
                            aria-controls="{{ $tab['id'] }}"
                            aria-selected="{{ $index === 0 ? 'true' : 'false' }}"
                        >{{ $tab['name'] }}</button>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="tab-content" id="myTabContent">
            @foreach($activeTabs as $index => $tab)
                <div
                    class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
                    id="{{ $tab['id'] }}"
                    role="tabpanel"
                    aria-labelledby="nav-{{ $tab['id'] }}"
                >
                    <div class="row product-grid-4">
                        @foreach($tab['products'] as $product)
                            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn" data-wow-delay="{{ $product->delay }}">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <a href="{{ $product->url }}">
                                                <img class="default-img" src="{{ $product->image }}" alt="{{ $product->name }}" />
                                                @if($product->hoverImage)
                                                    <img class="hover-img" src="{{ $product->hoverImage }}" alt="{{ $product->name }}" />
                                                @endif
                                            </a>
                                        </div>
                                        <div class="product-action-1">
                                            <a aria-label="Add To Wishlist" class="action-btn" href="#"><i class="fi-rs-heart"></i></a>
                                            <a aria-label="Compare" class="action-btn" href="#"><i class="fi-rs-shuffle"></i></a>
                                            <a aria-label="Quick view" class="action-btn quickview-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal" data-product-slug="{{ $product->slug }}"><i class="fi-rs-eye"></i></a>
                                        </div>
                                        @if($product->badge)
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="{{ $product->badge }}">
                                                    @if($product->hasDiscount())
                                                        -{{ $product->discountPercent() }}%
                                                    @else
                                                        {{ ucfirst($product->badge) }}
                                                    @endif
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="product-category">
                                            <a href="{{ route('shop.index', ['category' => $product->categorySlug]) }}">{{ $product->categoryName }}</a>
                                        </div>
                                        <h2><a href="{{ $product->url }}">{{ $product->name }}</a></h2>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: {{ $product->ratingPercent }}%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> ({{ $product->averageRating }})</span>
                                        </div>
                                        @if($product->brandName)
                                            <div>
                                                <span class="font-small text-muted">By <a href="#">{{ $product->brandName }}</a></span>
                                            </div>
                                        @endif
                                        <div class="product-card-bottom">
                                            <div class="product-price">
                                                <span>${{ number_format($product->displayPrice(), 2) }}</span>
                                                @if($product->hasDiscount())
                                                    <span class="old-price">${{ number_format($product->price, 2) }}</span>
                                                @endif
                                            </div>
                                            <div class="add-cart">
                                                <a class="add" href="{{ $product->url }}"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
