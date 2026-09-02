<x-frontend title="Checkout - Nest">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('home') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> Shop
                <span></span> Checkout
            </div>
        </div>
    </div>
    <div class="container mb-80 mt-50">
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="row">
            <div class="col-lg-8 mb-40">
                <h1 class="heading-2 mb-10">Checkout</h1>
                <div class="d-flex justify-content-between">
                    <h6 class="text-body">There are <span class="text-brand">{{ $cartItems->sum('quantity') }}</span> products in your cart</h6>
                </div>
            </div>
        </div>

        <div class="row mb-30">
            <div class="col-lg-6 mb-30">
                <div class="toggle_info">
                    <span><i class="fi-rs-user mr-10"></i><span class="text-muted font-lg">Signed in as</span> <strong class="font-lg">{{ auth()->user()->name }}</strong></span>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="toggle_info">
                    <span><i class="fi-rs-label mr-10"></i><span class="text-muted font-lg">Have a coupon?</span> <a data-bs-toggle="collapse" href="#couponForm" class="collapsed font-lg" aria-expanded="false">Click here to enter your code</a></span>
                    <div class="panel-collapse collapse" id="couponForm">
                        <div class="panel-body">
                            <p class="mb-30 font-sm">If you have a coupon code, please apply it below.</p>
                            <div class="form-group">
                                <div class="d-flex">
                                    <input class="font-medium mr-15 coupon" name="coupon" placeholder="Enter Your Coupon">
                                    <button class="btn btn-md" type="button"><i class="fi-rs-label mr-10"></i>Apply</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form id="checkout-form" method="post" action="{{ route('checkout.store') }}">
            @csrf
            <div class="row">
                <div class="col-lg-7">
                    <h4 class="mb-30">Billing Details</h4>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <input type="text" name="shipping_full_name" required value="{{ old('shipping_full_name', auth()->user()->name ?? '') }}" placeholder="Full name *">
                        </div>
                        <div class="form-group col-lg-6">
                            <input type="text" name="shipping_phone" required value="{{ old('shipping_phone') }}" placeholder="Phone *">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <input type="text" name="shipping_address_line_1" required value="{{ old('shipping_address_line_1') }}" placeholder="Address *">
                        </div>
                        <div class="form-group col-lg-6">
                            <input type="text" name="shipping_city" required value="{{ old('shipping_city') }}" placeholder="City / Town *">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <input type="text" name="shipping_state" required value="{{ old('shipping_state') }}" placeholder="State / County *">
                        </div>
                        <div class="form-group col-lg-6">
                            <input type="text" name="shipping_postal_code" required value="{{ old('shipping_postal_code') }}" placeholder="Postcode / ZIP *">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <div class="custom_select">
                                <select name="shipping_country" class="form-control select-active">
                                    <option value="">Select a country...</option>
                                    <option value="USA" @selected(old('shipping_country', 'USA') === 'USA')>United States (US)</option>
                                    <option value="CAN" @selected(old('shipping_country') === 'CAN')>Canada</option>
                                    <option value="GBR" @selected(old('shipping_country') === 'GBR')>United Kingdom</option>
                                    <option value="DEU" @selected(old('shipping_country') === 'DEU')>Germany</option>
                                    <option value="FRA" @selected(old('shipping_country') === 'FRA')>France</option>
                                    <option value="AUS" @selected(old('shipping_country') === 'AUS')>Australia</option>
                                    <option value="IND" @selected(old('shipping_country') === 'IND')>India</option>
                                    <option value="UAE" @selected(old('shipping_country') === 'UAE')>United Arab Emirates</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-lg-6">
                            <input type="email" disabled value="{{ auth()->user()->email ?? '' }}" placeholder="Email address">
                        </div>
                    </div>
                    <div class="form-group mb-30">
                        <textarea rows="5" name="notes" placeholder="Additional information">{{ old('notes') }}</textarea>
                    </div>
                    <div class="ship_detail">
                        <div class="form-group">
                            <div class="chek-form">
                                <div class="custome-checkbox">
                                    <input class="form-check-input" type="checkbox" name="different_address" id="differentaddress">
                                    <label class="form-check-label label_info" data-bs-toggle="collapse" data-target="#collapseAddress" href="#collapseAddress" aria-controls="collapseAddress" for="differentaddress"><span>Ship to a different address?</span></label>
                                </div>
                            </div>
                        </div>
                        <div id="collapseAddress" class="different_address collapse">
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <input type="text" name="billing_full_name" value="{{ old('billing_full_name') }}" placeholder="Full name *">
                                </div>
                                <div class="form-group col-lg-6">
                                    <input type="text" name="billing_phone" value="{{ old('billing_phone') }}" placeholder="Phone *">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <input type="text" name="billing_address_line_1" value="{{ old('billing_address_line_1') }}" placeholder="Address *">
                                </div>
                                <div class="form-group col-lg-6">
                                    <input type="text" name="billing_city" value="{{ old('billing_city') }}" placeholder="City / Town *">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <input type="text" name="billing_state" value="{{ old('billing_state') }}" placeholder="State / County *">
                                </div>
                                <div class="form-group col-lg-6">
                                    <input type="text" name="billing_postal_code" value="{{ old('billing_postal_code') }}" placeholder="Postcode / ZIP *">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="border p-40 cart-totals ml-30 mb-50">
                        <div class="d-flex align-items-end justify-content-between mb-30">
                            <h4>Your Order</h4>
                            <h6 class="text-muted">Subtotal</h6>
                        </div>
                        <div class="divider-2 mb-30"></div>
                        <div class="table-responsive order_table checkout">
                            <table class="table no-border">
                                <tbody>
                                    @foreach($cartItems as $item)
                                        @php
                                            $linePrice = ($item->product->sale_price ?? $item->product->price) * $item->quantity;
                                        @endphp
                                        <tr>
                                            <td class="image product-thumbnail">
                                                <a href="{{ route('product.show', $item->product->slug) }}">
                                                    @if($item->product->primaryImage)
                                                        <img src="{{ asset($item->product->primaryImage->image_path) }}" alt="{{ $item->product->name }}">
                                                    @endif
                                                </a>
                                            </td>
                                            <td>
                                                <h6 class="w-160 mb-5"><a href="{{ route('product.show', $item->product->slug) }}" class="text-heading">{{ $item->product->name }}</a></h6>
                                            </td>
                                            <td>
                                                <h6 class="text-muted pl-20 pr-20">x {{ $item->quantity }}</h6>
                                            </td>
                                            <td>
                                                <h4 class="text-brand">${{ number_format($linePrice, 2) }}</h4>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="divider-2 mb-30"></div>
                        <table class="table no-border">
                            <tbody>
                                <tr>
                                    <td class="cart_total_label">
                                        <h6 class="text-muted">Subtotal</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h5 class="text-heading text-end">${{ number_format($subtotal, 2) }}</h5>
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
                    <div class="payment ml-30">
                        <h4 class="mb-30">Payment</h4>
                        <div class="payment_option">
                            <div class="custome-radio">
                                <input class="form-check-input" type="radio" name="payment_method" id="pm-cod" value="cod" checked>
                                <label class="form-check-label" for="pm-cod">Cash on delivery</label>
                            </div>
                            <div class="custome-radio">
                                <input class="form-check-input" type="radio" name="payment_method" id="pm-bank" value="bank_transfer">
                                <label class="form-check-label" for="pm-bank">Direct Bank Transfer</label>
                            </div>
                            <div class="custome-radio">
                                <input class="form-check-input" type="radio" name="payment_method" id="pm-online" value="online">
                                <label class="form-check-label" for="pm-online">Online Gateway</label>
                            </div>
                        </div>
                        <div class="payment-logo d-flex">
                            <img class="mr-15" src="{{ asset('assets/imgs/theme/icons/payment-paypal.svg') }}" alt="">
                            <img class="mr-15" src="{{ asset('assets/imgs/theme/icons/payment-visa.svg') }}" alt="">
                            <img class="mr-15" src="{{ asset('assets/imgs/theme/icons/payment-master.svg') }}" alt="">
                            <img src="{{ asset('assets/imgs/theme/icons/payment-zapper.svg') }}" alt="">
                        </div>
                        <button type="submit" class="btn btn-fill-out btn-block mt-30">Place an Order<i class="fi-rs-sign-out ml-15"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-frontend>