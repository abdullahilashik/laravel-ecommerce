@props(['deals' => []])

@if(count($deals) > 0)
<section class="section-padding pb-5">
    <div class="container">
        <div class="section-title wow animate__animated animate__fadeIn" data-wow-delay="0">
            <h3 class="">Deals Of The Day</h3>
            <a class="show-all" href="{{ route('shop.index') }}">
                All Deals
                <i class="fi-rs-angle-right"></i>
            </a>
        </div>
        <div class="row">
            @foreach($deals as $index => $product)
                <div class="col-xl-3 col-lg-4 col-md-6 {{ $index === 2 ? 'd-none d-lg-block' : '' }} {{ $index === 3 ? 'd-none d-xl-block' : '' }}">
                    <div class="product-cart-wrap style-2 wow animate__animated animate__fadeInUp" data-wow-delay="0.{{ $index }}s">
                        <div class="product-img-action-wrap">
                            <div class="product-img">
                                <a href="{{ $product->url }}">
                                    <img src="{{ $product->image }}" alt="{{ $product->name }}" />
                                </a>
                            </div>
                        </div>
                        <div class="product-content-wrap">
                            <div class="deals-countdown-wrap">
                                <div class="deals-countdown" data-countdown="{{ now()->addDays($index + 1)->format('Y/m/d H:i:s') }}"></div>
                            </div>
                            <div class="deals-content">
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
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
