<x-frontend title="{{ $currentCategory?->name ?? 'Shop' }} - Nest">
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/plugins/slider-range.css') }}" />
    @endpush

    @php
        $preserve = fn(array $overrides = [], array $remove = ['page']) => route(
            'shop.index',
            collect(request()->query())->except($remove)->merge($overrides)->all()
        );

        $perPage   = request('per_page') ?: '12';
        $perPageLabel = match ($perPage) { '24' => '24', '48' => '48', 'all' => 'All', default => '12' };

        $sort      = request('sort') ?: 'featured';
        $sortLabel = match ($sort) {
            'price_low'  => 'Price: Low to High',
            'price_high' => 'Price: High to Low',
            'newest'     => 'Release Date',
            'rating'     => 'Avg. Rating',
            default      => 'Featured',
        };
    @endphp

    <div class="page-header mt-30 mb-50">
        <div class="container">
            <div class="archive-header">
                <div class="row align-items-center">
                    <div class="col-xl-3">
                        <h1 class="mb-15">{{ $currentCategory?->name ?? 'Shop' }}</h1>
                        <div class="breadcrumb">
                            <a href="{{ route('home') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                            <span></span> Shop
                            @if($currentCategory)
                                <span></span> {{ $currentCategory->name }}
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-9 text-end d-none d-xl-block">
                        <ul class="tags-list">
                            @foreach($categories->take(5) as $category)
                                @php
                                    $active = request('category') == $category->slug;
                                @endphp
                                <li class="hover-up {{ $active ? 'active' : '' }} {{ $loop->last ? 'mr-0' : '' }}">
                                    <a href="{{ $active
                                        ? $preserve([], ['category', 'page'])
                                        : $preserve(['category' => $category->slug]) }}"><i class="fi-rs-cross mr-10"></i>{{ $category->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mb-30">
        <div class="row flex-row-reverse">
            <div class="col-lg-4-5">
                <div class="shop-product-fillter">
                    <div class="totall-product">
                        <p>We found <strong class="text-brand">{{ $products->total() }}</strong> items for you!</p>
                    </div>
                    <div class="sort-by-product-area">
                        <div class="sort-by-cover mr-10">
                            <div class="sort-by-product-wrap">
                                <div class="sort-by">
                                    <span><i class="fi-rs-apps"></i>Show:</span>
                                </div>
                                <div class="sort-by-dropdown-wrap">
                                    <span> {{ $perPageLabel }} <i class="fi-rs-angle-small-down"></i></span>
                                </div>
                            </div>
                            <div class="sort-by-dropdown">
                                <ul>
                                    @foreach(['12' => '12', '24' => '24', '48' => '48', 'all' => 'All'] as $value => $label)
                                        <li><a class="{{ $perPage === $value ? 'active' : '' }}" href="{{ $preserve(['per_page' => $value]) }}">{{ $label }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="sort-by-cover">
                            <div class="sort-by-product-wrap">
                                <div class="sort-by">
                                    <span><i class="fi-rs-apps-sort"></i>Sort by:</span>
                                </div>
                                <div class="sort-by-dropdown-wrap">
                                    <span> {{ $sortLabel }} <i class="fi-rs-angle-small-down"></i></span>
                                </div>
                            </div>
                            <div class="sort-by-dropdown">
                                <ul>
                                    @foreach([
                                        'featured'   => 'Featured',
                                        'price_low'  => 'Price: Low to High',
                                        'price_high' => 'Price: High to Low',
                                        'newest'     => 'Release Date',
                                        'rating'     => 'Avg. Rating',
                                    ] as $value => $label)
                                        <li><a class="{{ $sort === $value ? 'active' : '' }}" href="{{ $preserve(['sort' => $value]) }}">{{ $label }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row product-grid">
                    @forelse($products as $product)
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
                                    @if($product->categoryName)
                                        <div class="product-category">
                                            <a href="{{ $preserve(['category' => $product->categorySlug]) }}">{{ $product->categoryName }}</a>
                                        </div>
                                    @endif
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
                    @empty
                        <div class="col-12">
                            <div class="text-center py-5">
                                <h4>No products found</h4>
                                <p class="text-muted">Try adjusting your filters or search terms.</p>
                                <a href="{{ route('shop.index') }}" class="btn btn-sm btn-default mt-2">Clear filters</a>
                            </div>
                        </div>
                    @endforelse
                </div>
                <div class="pagination-area mt-20 mb-20">
                    {{ $products->links('vendor.pagination.nest') }}
                </div>
                <section class="section-padding pb-5">
                    <div class="section-title">
                        <h3 class="">Deals Of The Day</h3>
                        <a class="show-all" href="{{ route('shop.index') }}">
                            All Deals
                            <i class="fi-rs-angle-right"></i>
                        </a>
                    </div>
                    <div class="row">
                        @foreach($dealsOfDay as $index => $product)
                            <div class="col-xl-3 col-lg-4 col-md-6 {{ $index === 2 ? 'd-none d-lg-block' : '' }} {{ $index === 3 ? 'd-none d-xl-block' : '' }}">
                                <div class="product-cart-wrap style-2">
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
                </section>
            </div>
            <div class="col-lg-1-5 primary-sidebar sticky-sidebar">
                <div class="sidebar-widget widget-category-2 mb-30">
                    <h5 class="section-title style-1 mb-30">Category</h5>
                    <ul>
                        @foreach($categories as $category)
                            <li>
                                <a href="{{ $preserve(['category' => $category->slug]) }}">
                                    <img src="{{ asset('assets/imgs/theme/icons/category-' . ((($category->id - 1) % 11) + 1) . '.svg') }}" alt="" />{{ $category->name }}
                                </a><span class="count">{{ $category->products_count }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <!-- Fillter By Price -->
                <div class="sidebar-widget price_range range mb-30">
                    <h5 class="section-title style-1 mb-30">Fill by price</h5>
                    <form action="{{ route('shop.index') }}" method="GET">
                        <input type="hidden" name="min_price" id="min_price" value="{{ request('min_price') }}" />
                        <input type="hidden" name="max_price" id="max_price" value="{{ request('max_price') }}" />
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}" />
                        @endif
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}" />
                        @endif
                        @if(request('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}" />
                        @endif
                        @if(request('per_page'))
                            <input type="hidden" name="per_page" value="{{ request('per_page') }}" />
                        @endif
                        <div class="price-filter">
                            <div class="price-filter-inner">
                                <div
                                    id="slider-price"
                                    class="mb-20"
                                    data-min="0"
                                    data-max="{{ $priceLimit }}"
                                    data-value-min="{{ request('min_price') }}"
                                    data-value-max="{{ request('max_price') }}"
                                ></div>
                                <div class="d-flex justify-content-between">
                                    <div class="caption">From: <strong id="slider-price-value1" class="text-brand">${{ request('min_price', 0) }}</strong></div>
                                    <div class="caption">To: <strong id="slider-price-value2" class="text-brand">${{ request('max_price', $priceLimit) }}</strong></div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group">
                            <div class="list-group-item mb-10 mt-10">
                                <label class="fw-900">Brand</label>
                                <div class="custome-checkbox">
                                    @foreach($brands as $brand)
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="brand[]"
                                            id="brand-{{ $brand->id }}"
                                            value="{{ $brand->slug }}"
                                            {{ in_array($brand->slug, (array) request('brand', []), true) ? 'checked' : '' }}
                                        />
                                        <label class="form-check-label" for="brand-{{ $brand->id }}"><span>{{ $brand->name }} ({{ $brand->products_count }})</span></label>
                                        <br />
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-default"><i class="fi-rs-filter mr-5"></i> Fillter</button>
                    </form>
                </div>
                <!-- Product sidebar Widget -->
                <div class="sidebar-widget product-sidebar mb-30 p-30 bg-grey border-radius-10">
                    <h5 class="section-title style-1 mb-30">New products</h5>
                    @foreach($newProducts as $product)
                        <div class="single-post clearfix">
                            <div class="image">
                                <img src="{{ $product->image }}" alt="{{ $product->name }}" />
                            </div>
                            <div class="content pt-10">
                                <h6><a href="{{ $product->url }}">{{ $product->name }}</a></h6>
                                <p class="price mb-0 mt-5">${{ number_format($product->displayPrice(), 2) }}</p>
                                <div class="product-rate">
                                    <div class="product-rating" style="width: {{ $product->ratingPercent }}%"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="banner-img wow fadeIn mb-lg-0 animated d-lg-block d-none">
                    <img src="{{ asset('assets/imgs/banner/banner-11.png') }}" alt="" />
                    <div class="banner-text">
                        <span>Oganic</span>
                        <h4>
                            Save 17% <br />
                            on <span class="text-brand">Oganic</span><br />
                            Juice
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/js/plugins/slider-range.js') }}"></script>
        <script>
            (function ($) {
                'use strict';
                $(function () {
                    var $slider = $('#slider-price');
                    if (!$slider.length || typeof noUiSlider === 'undefined') {
                        return;
                    }
                    var minVal = parseInt($slider.data('min'), 10) || 0;
                    var maxVal = parseInt($slider.data('max'), 10) || 100;
                    var curMin = parseInt($slider.data('value-min'), 10);
                    var curMax = parseInt($slider.data('value-max'), 10);
                    if (isNaN(curMin)) { curMin = minVal; }
                    if (isNaN(curMax)) { curMax = maxVal; }
                    var options = {
                        start: [curMin, curMax],
                        connect: true,
                        step: 1,
                        range: { min: minVal, max: maxVal }
                    };
                    if (typeof wNumb !== 'undefined') {
                        options.format = wNumb({ decimals: 0, thousand: '' });
                    }
                    noUiSlider.create($slider[0], options);
                    var $value1 = $('#slider-price-value1');
                    var $value2 = $('#slider-price-value2');
                    var $inputMin = $('#min_price');
                    var $inputMax = $('#max_price');
                    $slider[0].noUiSlider.on('update', function (values, handle) {
                        var value = parseInt(values[handle], 10);
                        if (handle === 0) {
                            $value1.text('$' + value);
                        } else {
                            $value2.text('$' + value);
                        }
                    });
                    $slider[0].noUiSlider.on('change', function (values) {
                        $inputMin.val(values[0]);
                        $inputMax.val(values[1]);
                    });
                });
            })(jQuery);
        </script>
    @endpush
</x-frontend>
