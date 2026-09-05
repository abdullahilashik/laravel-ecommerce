@props([
    'categories' => collect(),
    'cartItems' => collect(),
    'cartSubtotal' => 0,
    'cartCount' => 0,
    'wishlistCount' => 0,
])
@php
    $allCats = $categories->values();
    $mainCats = $allCats->take(10);
    $moreCats = $allCats->slice(10);
    $mainHalf = (int) ceil($mainCats->count() / 2);
    $moreHalf = (int) ceil($moreCats->count() / 2);
    $accountUrl = auth()->check() ? route('account.index') : route('login');
    $wishlistUrl = auth()->check() ? route('wishlist.index') : route('login');
    $wishlistCount = auth()->check() ? auth()->user()->wishlists()->count() : 0;
@endphp
<header class="header-area header-style-1 header-height-2">
        <div class="mobile-promotion">
            <span>Grand opening, <strong>up to 15%</strong> off all items. Only <strong>3 days</strong> left</span>
        </div>
        <div class="header-top header-top-ptb-1 d-none d-lg-block">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-3 col-lg-4">
                        <div class="header-info">
                            <ul>
                                <li><a href="#">About Us</a></li>
                                <li><a href="{{ $accountUrl }}">My Account</a></li>
                                <li><a href="{{ $wishlistUrl }}">Wishlist</a></li>
                                <li><a href="#">Order Tracking</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-4">
                        <div class="text-center">
                            <div id="news-flash" class="d-inline-block">
                                <ul>
                                    <li>100% Secure delivery without contacting the courier</li>
                                    <li>Supper Value Deals - Save more with coupons</li>
                                    <li>Trendy 25silver jewelry, save up 35% off today</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4">
                        <div class="header-info header-info-right">
                            <ul>
                                <li>Need help? Call Us: <strong class="text-brand"> + 1800 900</strong></li>
                                <li>
                                    <a class="language-dropdown-active" href="#">English <i class="fi-rs-angle-small-down"></i></a>
                                    <ul class="language-dropdown">
                                        <li>
                                            <a href="#"><img src="{{ asset('assets/imgs/theme/flag-fr.png') }}" alt="" />Français</a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="{{ asset('assets/imgs/theme/flag-dt.png') }}" alt="" />Deutsch</a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="{{ asset('assets/imgs/theme/flag-ru.png') }}" alt="" />Pусский</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a class="language-dropdown-active" href="#">USD <i class="fi-rs-angle-small-down"></i></a>
                                    <ul class="language-dropdown">
                                        <li>
                                            <a href="#"><img src="{{ asset('assets/imgs/theme/flag-fr.png') }}" alt="" />INR</a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="{{ asset('assets/imgs/theme/flag-dt.png') }}" alt="" />MBP</a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="{{ asset('assets/imgs/theme/flag-ru.png') }}" alt="" />EU</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-middle header-middle-ptb-1 d-none d-lg-block">
            <div class="container">
                <div class="header-wrap">
                    <div class="logo logo-width-1">
                        <a href="{{ route('home') }}"><img src="{{ asset('assets/imgs/theme/logo.svg') }}" alt="logo" /></a>
                    </div>
                    <div class="header-right">
                        <div class="search-style-2">
                            <form action="{{ route('shop.index') }}" method="GET">
                                <select name="category" class="select-active">
                                    <option value="">All Categories</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search for items..." />
                            </form>
                        </div>
                        <div class="header-action-right">
                            <div class="header-action-2">
                                <div class="search-location">
                                    <form action="#">
                                        <select class="select-active">
                                            <option>Your Location</option>
                                            <option>Alabama</option>
                                            <option>Alaska</option>
                                            <option>Arizona</option>
                                            <option>Delaware</option>
                                            <option>Florida</option>
                                            <option>Georgia</option>
                                            <option>Hawaii</option>
                                            <option>Indiana</option>
                                            <option>Maryland</option>
                                            <option>Nevada</option>
                                            <option>New Jersey</option>
                                            <option>New Mexico</option>
                                            <option>New York</option>
                                        </select>
                                    </form>
                                </div>
                                <div class="header-action-icon-2">
                                    <a href="#">
                                        <img class="svgInject" alt="Nest" src="{{ asset('assets/imgs/theme/icons/icon-compare.svg') }}" />
                                        <span class="pro-count blue">0</span>
                                    </a>
                                    <a href="#"><span class="lable ml-0">Compare</span></a>
                                </div>
                                <div class="header-action-icon-2">
                                    <a href="{{ $wishlistUrl }}">
                                        <img class="svgInject" alt="Nest" src="{{ asset('assets/imgs/theme/icons/icon-heart.svg') }}" />
                                        <span class="pro-count blue" id="wishlist-count-desktop">{{ $wishlistCount }}</span>
                                    </a>
                                    <a href="{{ $wishlistUrl }}"><span class="lable">Wishlist</span></a>
                                </div>
                                <div class="header-action-icon-2">
                                    <a class="mini-cart-icon" href="{{ route('cart.index') }}">
                                        <img alt="Nest" src="{{ asset('assets/imgs/theme/icons/icon-cart.svg') }}" />
                                        <span class="pro-count blue" id="cart-count-desktop">{{ $cartCount }}</span>
                                    </a>
                                    <a href="{{ route('cart.index') }}"><span class="lable">Cart</span></a>
                                    <div class="cart-dropdown-wrap cart-dropdown-hm2" id="cart-dropdown-desktop">
                                        @include('components.frontend.header.cart-dropdown', ['cartItems' => $cartItems, 'cartSubtotal' => $cartSubtotal, 'prefix' => 'd'])
                                    </div>
                                </div>
                                <div class="header-action-icon-2">
                                    <a href="{{ $accountUrl }}">
                                        <img class="svgInject" alt="Nest" src="{{ asset('assets/imgs/theme/icons/icon-user.svg') }}" />
                                    </a>
                                    <a href="{{ $accountUrl }}"><span class="lable ml-0">Account</span></a>
                                    <div class="cart-dropdown-wrap cart-dropdown-hm2 account-dropdown">
                                        <ul>
                                            @auth
                                                <li>
                                                    <a href="{{ route('account.index') }}"><i class="fi fi-rs-user mr-10"></i>My Account</a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('profile.edit') }}"><i class="fi fi-rs-settings-sliders mr-10"></i>Setting</a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fi fi-rs-sign-out mr-10"></i>Sign out</a>
                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                                                </li>
                                            @else
                                                <li>
                                                    <a href="{{ route('login') }}"><i class="fi fi-rs-sign-in mr-10"></i>Login</a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('register') }}"><i class="fi fi-rs-user mr-10"></i>Register</a>
                                                </li>
                                            @endauth
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom header-bottom-bg-color sticky-bar">
            <div class="container">
                <div class="header-wrap header-space-between position-relative">
                    <div class="logo logo-width-1 d-block d-lg-none">
                        <a href="{{ route('home') }}"><img src="{{ asset('assets/imgs/theme/logo.svg') }}" alt="logo" /></a>
                    </div>
                    <div class="header-nav d-none d-lg-flex">
                        <div class="main-categori-wrap d-none d-lg-block">
                            <a class="categories-button-active" href="#">
                                <span class="fi-rs-apps"></span> <span class="et">Browse</span> All Categories
                                <i class="fi-rs-angle-down"></i>
                            </a>
                            <div class="categories-dropdown-wrap categories-dropdown-active-large font-heading">
                                @if ($mainCats->isNotEmpty())
                                    <div class="d-flex categori-dropdown-inner">
                                        <ul>
                                            @foreach ($mainCats->take($mainHalf) as $index => $category)
                                                <li>
                                                    <a href="{{ route('category.show', $category->slug) }}"> <img src="{{ asset('assets/imgs/theme/icons/category-' . (($index % 10) + 1) . '.svg') }}" alt="" />{{ $category->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <ul class="end">
                                            @foreach ($mainCats->slice($mainHalf) as $index => $category)
                                                <li>
                                                    <a href="{{ route('category.show', $category->slug) }}"> <img src="{{ asset('assets/imgs/theme/icons/category-' . ((($index + $mainHalf) % 10) + 1) . '.svg') }}" alt="" />{{ $category->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if ($moreCats->isNotEmpty())
                                    <div class="more_slide_open" style="display: none">
                                        <div class="d-flex categori-dropdown-inner">
                                            <ul>
                                                @foreach ($moreCats->take($moreHalf) as $index => $category)
                                                    <li>
                                                        <a href="{{ route('category.show', $category->slug) }}"> <img src="{{ asset('assets/imgs/theme/icons/category-' . ((($index + 10) % 10) + 1) . '.svg') }}" alt="" />{{ $category->name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <ul class="end">
                                                @foreach ($moreCats->slice($moreHalf) as $index => $category)
                                                    <li>
                                                        <a href="{{ route('category.show', $category->slug) }}"> <img src="{{ asset('assets/imgs/theme/icons/category-' . ((($index + 10 + $moreHalf) % 10) + 1) . '.svg') }}" alt="" />{{ $category->name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="more_categories"><span class="icon"></span> <span class="heading-sm-1">Show more...</span></div>
                                @endif
                            </div>
                        </div>
                        <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block font-heading">
                            <nav>
                                <ul>
                                    <li class="hot-deals"><img src="{{ asset('assets/imgs/theme/icons/icon-hot.svg') }}" alt="hot deals" /><a href="{{ route('shop.index') }}">Deals</a></li>
                                    <li>
                                        <a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                                    </li>
                                    <li>
                                        <a class="{{ request()->routeIs('shop.index') ? 'active' : '' }}" href="{{ route('shop.index') }}">Shop</a>
                                    </li>
                                    <li>
                                        <a href="#">Contact</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="hotline d-none d-lg-flex">
                        <img src="{{ asset('assets/imgs/theme/icons/icon-headphone.svg') }}" alt="hotline" />
                        <p>1900 - 888<span>24/7 Support Center</span></p>
                    </div>
                    <div class="header-action-icon-2 d-block d-lg-none">
                        <div class="burger-icon burger-icon-white">
                            <span class="burger-icon-top"></span>
                            <span class="burger-icon-mid"></span>
                            <span class="burger-icon-bottom"></span>
                        </div>
                    </div>
                    <div class="header-action-right d-block d-lg-none">
                        <div class="header-action-2">
                            <div class="header-action-icon-2">
                                <a href="{{ $wishlistUrl }}">
                                    <img alt="Nest" src="{{ asset('assets/imgs/theme/icons/icon-heart.svg') }}" />
                                    <span class="pro-count white" id="wishlist-count-mobile">{{ $wishlistCount }}</span>
                                </a>
                            </div>
                            <div class="header-action-icon-2">
                                <a class="mini-cart-icon" href="{{ route('cart.index') }}">
                                    <img alt="Nest" src="{{ asset('assets/imgs/theme/icons/icon-cart.svg') }}" />
                                    <span class="pro-count white" id="cart-count-mobile">{{ $cartCount }}</span>
                                </a>
                                <div class="cart-dropdown-wrap cart-dropdown-hm2" id="cart-dropdown-mobile">
                                    @include('components.frontend.header.cart-dropdown', ['cartItems' => $cartItems, 'cartSubtotal' => $cartSubtotal, 'prefix' => 'm'])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="mobile-header-active mobile-header-wrapper-style">
        <div class="mobile-header-wrapper-inner">
            <div class="mobile-header-top">
                <div class="mobile-header-logo">
                    <a href="{{ route('home') }}"><img src="{{ asset('assets/imgs/theme/logo.svg') }}" alt="logo" /></a>
                </div>
                <div class="mobile-menu-close close-style-wrap close-style-position-inherit">
                    <button class="close-style search-close">
                        <i class="icon-top"></i>
                        <i class="icon-bottom"></i>
                    </button>
                </div>
            </div>
            <div class="mobile-header-content-area">
                <div class="mobile-search search-style-3 mobile-header-border">
                    <form action="{{ route('shop.index') }}" method="GET">
                        <input type="text" name="search" placeholder="Search for items…" />
                        <button type="submit"><i class="fi-rs-search"></i></button>
                    </form>
                </div>
                <div class="mobile-menu-wrap mobile-header-border">
                    <!-- mobile menu start -->
                    <nav>
                        <ul class="mobile-menu font-heading">
                            <li>
                                <a href="{{ route('home') }}">Home</a>
                            </li>
                            <li>
                                <a href="{{ route('shop.index') }}">Shop</a>
                            </li>
                            <li>
                                <a href="{{ route('shop.index') }}">Deals</a>
                            </li>
                            <li>
                                <a href="#">Contact</a>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="#">All Categories</a>
                                <ul class="dropdown">
                                    @foreach ($categories as $category)
                                        <li>
                                            <a href="{{ route('category.show', $category->slug) }}">{{ $category->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </nav>
                    <!-- mobile menu end -->
                </div>
                <div class="mobile-header-info-wrap">
                    <div class="single-mobile-header-info">
                        <a href="#"><i class="fi-rs-marker"></i> Our location </a>
                    </div>
                    <div class="single-mobile-header-info">
                        <a href="{{ $accountUrl }}"><i class="fi-rs-user"></i>Log In / Sign Up </a>
                    </div>
                    <div class="single-mobile-header-info">
                        <a href="#"><i class="fi-rs-headphones"></i>(+01) - 2345 - 6789 </a>
                    </div>
                </div>
                <div class="mobile-social-icon mb-50">
                    <h6 class="mb-15">Follow Us</h6>
                    <a href="#"><img src="{{ asset('assets/imgs/theme/icons/icon-facebook-white.svg') }}" alt="" /></a>
                    <a href="#"><img src="{{ asset('assets/imgs/theme/icons/icon-twitter-white.svg') }}" alt="" /></a>
                    <a href="#"><img src="{{ asset('assets/imgs/theme/icons/icon-instagram-white.svg') }}" alt="" /></a>
                    <a href="#"><img src="{{ asset('assets/imgs/theme/icons/icon-pinterest-white.svg') }}" alt="" /></a>
                    <a href="#"><img src="{{ asset('assets/imgs/theme/icons/icon-youtube-white.svg') }}" alt="" /></a>
                </div>
                <div class="site-copyright">Copyright 2024 © Nest. All rights reserved. Powered by AliThemes.</div>
            </div>
        </div>
    </div>
