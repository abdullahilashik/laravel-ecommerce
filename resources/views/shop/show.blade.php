<x-frontend>
    @php
        $images = $product->images->sortBy('sort_order')->values();
        $hasDiscount = $product->sale_price && $product->sale_price < $product->price;
        $discountPct = $hasDiscount ? round((($product->price - $product->sale_price) / $product->price) * 100) : 0;
        $averageRating = (float) $product->reviews->avg('rating');
        $reviewCount = $product->reviews->count();
        $ratingPct = $averageRating * 20;
        $reviewsByStar = collect([5,4,3,2,1])->mapWithKeys(fn($star) => [$star => $product->reviews->where('rating', $star)->count()]);
        $totalForDist = max($reviewCount, 1);
    @endphp

    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('home') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span>
                @if($product->category)
                    <a href="{{ route('shop.index', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a>
                    <span></span>
                @endif
                {{ $product->name }}
            </div>
        </div>
    </div>
    <div class="container mb-30">
        <div class="row">
            <div class="col-xl-10 col-lg-12 m-auto">
                <div class="product-detail accordion-detail">
                    <div class="row mb-50 mt-30">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-md-0 mb-sm-5">
                            <div class="detail-gallery">
                                <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                                <div class="product-image-slider">
                                    @forelse($images as $img)
                                        <figure class="border-radius-10">
                                            <img src="{{ asset($img->image_path) }}" alt="{{ $img->alt_text ?: $product->name }}" />
                                        </figure>
                                    @empty
                                        <figure class="border-radius-10">
                                            <img src="{{ asset('assets/imgs/shop/product-16-2.jpg') }}" alt="{{ $product->name }}" />
                                        </figure>
                                    @endforelse
                                </div>
                                <div class="slider-nav-thumbnails">
                                    @forelse($images as $img)
                                        <div><img src="{{ asset($img->image_path) }}" alt="{{ $img->alt_text ?: $product->name }}" /></div>
                                    @empty
                                        <div><img src="{{ asset('assets/imgs/shop/thumbnail-3.jpg') }}" alt="{{ $product->name }}" /></div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="detail-info pr-30 pl-30">
                                @if($hasDiscount)
                                    <span class="stock-status out-stock"> Sale Off </span>
                                @endif
                                <h2 class="title-detail">{{ $product->name }}</h2>
                                <div class="product-detail-rating">
                                    <div class="product-rate-cover text-end">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width: {{ $ratingPct }}%"></div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> ({{ $reviewCount }} reviews)</span>
                                    </div>
                                </div>
                                <div class="clearfix product-price-cover">
                                    <div class="product-price primary-color float-left">
                                        <span class="current-price text-brand">${{ number_format($hasDiscount ? $product->sale_price : $product->price, 2) }}</span>
                                        @if($hasDiscount)
                                            <span>
                                                <span class="save-price font-md color3 ml-15">{{ $discountPct }}% Off</span>
                                                <span class="old-price font-md ml-15">${{ number_format($product->price, 2) }}</span>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                @if($product->excerpt)
                                    <div class="short-desc mb-30">
                                        <p class="font-lg">{{ $product->excerpt }}</p>
                                    </div>
                                @endif
                                @if($product->variants->isNotEmpty())
                                    <div class="attr-detail attr-size mb-30">
                                        <strong class="mr-10">Size / Weight: </strong>
                                        <ul class="list-filter size-filter font-small">
                                            @foreach($product->variants as $variant)
                                                <li @if($loop->first)class="active"@endif><a href="#">{{ $variant->name }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="detail-extralink mb-50">
                                    @csrf
                                    <div class="detail-qty border radius">
                                        <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                        <input type="text" name="quantity" class="qty-val" value="1" min="1">
                                        <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                    </div>
                                    <div class="product-extra-link2">
                                        <button type="submit" class="button button-add-to-cart"><i class="fi-rs-shopping-cart"></i>Add to cart</button>
                                        <a aria-label="Add To Wishlist" class="action-btn hover-up" href="#"><i class="fi-rs-heart"></i></a>
                                        <a aria-label="Compare" class="action-btn hover-up" href="#"><i class="fi-rs-shuffle"></i></a>
                                    </div>
                                </form>
                                <div class="font-xs">
                                    <ul class="mr-50 float-start">
                                        @if($product->brand)
                                            <li class="mb-5">Brand: <span class="text-brand">{{ $product->brand->name }}</span></li>
                                        @endif
                                        <li class="mb-5">SKU: <span class="text-brand">{{ $product->sku }}</span></li>
                                        <li class="mb-5">Stock: <span class="{{ $product->stock_quantity > 0 ? 'in-stock text-brand ml-5' : 'out-stock' }}">{{ $product->stock_quantity > 0 ? $product->stock_quantity . ' Items In Stock' : 'Out of Stock' }}</span></li>
                                    </ul>
                                    <ul class="float-start">
                                        @if($product->tags->isNotEmpty())
                                            <li class="mb-5">Tags: @foreach($product->tags as $tag)<a href="#" rel="tag">{{ $tag->name }}</a>@if(!$loop->last), @endif @endforeach</li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="tab-style3">
                            <ul class="nav nav-tabs text-uppercase">
                                <li class="nav-item">
                                    <a class="nav-link active" id="Description-tab" data-bs-toggle="tab" href="#Description">Description</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="Additional-info-tab" data-bs-toggle="tab" href="#Additional-info">Additional info</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="Vendor-info-tab" data-bs-toggle="tab" href="#Vendor-info">Vendor</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="Reviews-tab" data-bs-toggle="tab" href="#Reviews">Reviews ({{ $reviewCount }})</a>
                                </li>
                            </ul>
                            <div class="tab-content shop_info_tab entry-main-content">
                                <div class="tab-pane fade show active" id="Description">
                                    <div class="">
                                        {!! $product->description !!}
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="Additional-info">
                                    <table class="font-md">
                                        <tbody>
                                            <tr>
                                                <th>Brand</th>
                                                <td><p>{{ $product->brand->name ?? '-' }}</p></td>
                                            </tr>
                                            <tr>
                                                <th>Category</th>
                                                <td><p>{{ $product->category->name ?? '-' }}</p></td>
                                            </tr>
                                            <tr>
                                                <th>SKU</th>
                                                <td><p>{{ $product->sku }}</p></td>
                                            </tr>
                                            @if($product->shipping_weight)
                                                <tr>
                                                    <th>Weight</th>
                                                    <td><p>{{ $product->shipping_weight }} kg</p></td>
                                                </tr>
                                            @endif
                                            @if($product->shipping_width)
                                                <tr>
                                                    <th>Dimensions</th>
                                                    <td><p>{{ $product->shipping_width }} x {{ $product->shipping_height }} cm</p></td>
                                                </tr>
                                            @endif
                                            @foreach($product->variants as $variant)
                                                <tr>
                                                    <th>{{ $variant->name }}</th>
                                                    <td><p>{{ $variant->sku }} - ${{ number_format($variant->price, 2) }} ({{ $variant->stock_quantity }} in stock)</p></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="Vendor-info">
                                    @if($product->brand)
                                        <div class="vendor-logo d-flex mb-30">
                                            <div class="vendor-name ml-15">
                                                <h6>
                                                    <a href="#">{{ $product->brand->name }}</a>
                                                </h6>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="d-flex mb-55">
                                        <div class="mr-30">
                                            <p class="text-brand font-xs">Rating</p>
                                            <h4 class="mb-0">{{ $ratingPct }}%</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="Reviews">
                                    <div class="comments-area">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <h4 class="mb-30">Customer questions & answers</h4>
                                                <div class="comment-list">
                                                    @forelse($product->reviews->where('is_approved', true) as $review)
                                                        <div class="single-comment justify-content-between d-flex mb-30">
                                                            <div class="user justify-content-between d-flex">
                                                                <div class="thumb text-center">
                                                                    <a href="#" class="font-heading text-brand">{{ $review->user->name ?? 'Anonymous' }}</a>
                                                                </div>
                                                                <div class="desc">
                                                                    <div class="d-flex justify-content-between mb-10">
                                                                        <div class="d-flex align-items-center">
                                                                            <span class="font-xs text-muted">{{ $review->created_at->format('F j, Y \a\t g:i A') }}</span>
                                                                        </div>
                                                                        <div class="product-rate d-inline-block">
                                                                            <div class="product-rating" style="width: {{ $review->rating * 20 }}%"></div>
                                                                        </div>
                                                                    </div>
                                                                    <p class="mb-10">{{ $review->comment }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <p>No reviews yet. Be the first to review this product!</p>
                                                    @endforelse
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <h4 class="mb-30">Customer reviews</h4>
                                                <div class="d-flex mb-30">
                                                    <div class="product-rate d-inline-block mr-15">
                                                        <div class="product-rating" style="width: {{ $ratingPct }}%"></div>
                                                    </div>
                                                    <h6>{{ number_format($averageRating, 1) }} out of 5</h6>
                                                </div>
                                                @foreach([5,4,3,2,1] as $star)
                                                    @php $count = $reviewsByStar[$star]; $pct = $totalForDist > 0 ? round(($count / $totalForDist) * 100) : 0; @endphp
                                                    <div class="progress">
                                                        <span>{{ $star }} star</span>
                                                        <div class="progress-bar" role="progressbar" style="width: {{ $pct }}%" aria-valuenow="{{ $pct }}" aria-valuemin="0" aria-valuemax="100">{{ $pct }}%</div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="comment-form">
                                        <h4 class="mb-15">Add a review</h4>
                                        <div class="product-rate d-inline-block mb-30"></div>
                                        <div class="row">
                                            <div class="col-lg-8 col-md-12">
                                                <form class="form-contact comment_form" action="#" id="commentForm">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <textarea class="form-control w-100" name="comment" id="comment" cols="30" rows="9" placeholder="Write Comment"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <input class="form-control" name="name" id="name" type="text" placeholder="Name" />
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <input class="form-control" name="email" id="email" type="email" placeholder="Email" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" class="button button-contactForm">Submit Review</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($relatedProducts->isNotEmpty())
                    <div class="row mt-60">
                        <div class="col-12">
                            <h2 class="section-title style-1 mb-30">Related products</h2>
                        </div>
                        <div class="col-12">
                            <div class="row related-products">
                                @foreach($relatedProducts as $related)
                                    @php
                                        $rImages = $related->images->sortBy('sort_order')->values();
                                        $rPrimary = $related->primaryImage;
                                        $rHover = $rImages->first(fn($img) => ! $img->is_primary) ?? $rPrimary;
                                        $rHasDiscount = $related->sale_price && $related->sale_price < $related->price;
                                        $rDiscountPct = $rHasDiscount ? round((($related->price - $related->sale_price) / $related->price) * 100) : 0;
                                    @endphp
                                    <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                                        <div class="product-cart-wrap hover-up">
                                            <div class="product-img-action-wrap">
                                                <div class="product-img product-img-zoom">
                                                    <a href="{{ route('product.show', $related->slug) }}" tabindex="0">
                                                        <img class="default-img" src="{{ $rPrimary ? asset($rPrimary->image_path) : '' }}" alt="{{ $related->name }}" />
                                                        @if($rHover)
                                                            <img class="hover-img" src="{{ asset($rHover->image_path) }}" alt="{{ $related->name }}" />
                                                        @endif
                                                    </a>
                                                </div>
                                                <div class="product-action-1">
                                                    <a aria-label="Quick view" class="action-btn small hover-up quickview-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal" data-product-slug="{{ $related->slug }}"><i class="fi-rs-search"></i></a>
                                                    <a aria-label="Add To Wishlist" class="action-btn small hover-up" href="#" tabindex="0"><i class="fi-rs-heart"></i></a>
                                                    <a aria-label="Compare" class="action-btn small hover-up" href="#" tabindex="0"><i class="fi-rs-shuffle"></i></a>
                                                </div>
                                                @if($rHasDiscount)
                                                    <div class="product-badges product-badges-position product-badges-mrg">
                                                        <span class="sale">-{{ $rDiscountPct }}%</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="product-content-wrap">
                                                <h2><a href="{{ route('product.show', $related->slug) }}" tabindex="0">{{ $related->name }}</a></h2>
                                                <div class="product-price">
                                                    <span>${{ number_format($rHasDiscount ? $related->sale_price : $related->price, 2) }} </span>
                                                    @if($rHasDiscount)
                                                        <span class="old-price">${{ number_format($related->price, 2) }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-frontend>
