<x-frontend title="My Account - Nest">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('home') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> Pages
                <span></span> My Account
            </div>
        </div>
    </div>
    <div class="page-content pt-150 pb-150">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success mb-30">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger mb-30">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger mb-30">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row">
                <div class="col-lg-10 m-auto">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="dashboard-menu">
                                <ul class="nav flex-column" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="dashboard-tab" data-bs-toggle="tab" href="#dashboard" role="tab" aria-controls="dashboard" aria-selected="false"><i class="fi-rs-settings-sliders mr-10"></i>Dashboard</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="orders-tab" data-bs-toggle="tab" href="#orders" role="tab" aria-controls="orders" aria-selected="false"><i class="fi-rs-shopping-bag mr-10"></i>Orders</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="track-orders-tab" data-bs-toggle="tab" href="#track-orders" role="tab" aria-controls="track-orders" aria-selected="false"><i class="fi-rs-shopping-cart-check mr-10"></i>Track Your Order</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="address-tab" data-bs-toggle="tab" href="#address" role="tab" aria-controls="address" aria-selected="true"><i class="fi-rs-marker mr-10"></i>My Address</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="account-detail-tab" data-bs-toggle="tab" href="#account-detail" role="tab" aria-controls="account-detail" aria-selected="true"><i class="fi-rs-user mr-10"></i>Account details</a>
                                    </li>
                                    <li class="nav-item">
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent"><i class="fi-rs-sign-out mr-10"></i>Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="tab-content account dashboard-content pl-50">
                                <div class="tab-pane fade active show" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="mb-0">Hello {{ $user->name }}!</h3>
                                        </div>
                                        <div class="card-body">
                                            <p>
                                                From your account dashboard you can easily check &amp; view your <a href="#orders" data-bs-toggle="tab">recent orders</a>,<br />
                                                manage your <a href="#address" data-bs-toggle="tab">shipping and billing addresses</a> and <a href="#account-detail" data-bs-toggle="tab">edit your password and account details.</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="mb-0">Your Orders</h3>
                                        </div>
                                        <div class="card-body">
                                            @if($orders->isEmpty())
                                                <p class="mb-0">You haven't placed any orders yet. <a href="{{ route('shop.index') }}">Start shopping</a></p>
                                            @else
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Order</th>
                                                                <th>Date</th>
                                                                <th>Status</th>
                                                                <th>Total</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($orders as $order)
                                                                <tr>
                                                                    <td>#{{ $order->order_number }}</td>
                                                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                                    <td>{{ ucfirst($order->status) }}</td>
                                                                    <td>${{ number_format($order->total_amount, 2) }} for {{ $order->items_count }} {{ Str::plural('item', $order->items_count) }}</td>
                                                                    <td><a href="{{ route('order.confirmation', $order->id) }}" class="btn-small d-block">View</a></td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="track-orders" role="tabpanel" aria-labelledby="track-orders-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="mb-0">Orders tracking</h3>
                                        </div>
                                        <div class="card-body contact-from-area">
                                            <p>To track your order please enter your OrderID in the box below and press "Track" button. This was given to you on your receipt and in the confirmation email you should have received.</p>
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <form class="contact-form-style mt-30 mb-50" action="{{ route('account.index') }}" method="GET">
                                                        <input type="hidden" name="tab" value="track-orders">
                                                        <div class="input-style mb-20">
                                                            <label>Order ID</label>
                                                            <input name="order-id" placeholder="Found in your order confirmation email" type="text" />
                                                        </div>
                                                        <div class="input-style mb-20">
                                                            <label>Billing email</label>
                                                            <input name="billing-email" placeholder="Email you used during checkout" type="email" />
                                                        </div>
                                                        <button class="submit submit-auto-width" type="submit">Track</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                                    @if($addresses->isEmpty())
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="mb-0">My Address</h3>
                                            </div>
                                            <div class="card-body">
                                                <p class="mb-0">You haven't saved any addresses yet.</p>
                                            </div>
                                        </div>
                                    @else
                                        <div class="row">
                                            @foreach($addresses as $address)
                                                <div class="col-lg-6">
                                                    <div class="card mb-3 mb-lg-0">
                                                        <div class="card-header">
                                                            <h3 class="mb-0">{{ $address->type === 'shipping' ? 'Shipping' : 'Billing' }} Address @if($address->is_default) <span class="text-brand">(Default)</span> @endif</h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <address>
                                                                <strong>{{ $address->full_name }}</strong><br />
                                                                {!! nl2br(e($address->address_line_1)) !!}{!! $address->address_line_2 ? '<br />' . nl2br(e($address->address_line_2)) : '' !!}<br />
                                                                {{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}<br />
                                                                {{ $address->country }}
                                                            </address>
                                                            @if($address->phone)
                                                                <p class="mb-2">Phone: {{ $address->phone }}</p>
                                                            @endif
                                                            <a href="{{ route('account.index') }}" class="btn-small">Edit</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                <div class="tab-pane fade" id="account-detail" role="tabpanel" aria-labelledby="account-detail-tab">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Account Details</h5>
                                        </div>
                                        <div class="card-body">
                                            <p>Update your account details or change your password below.</p>
                                            <form method="post" action="{{ route('account.update') }}">
                                                @csrf
                                                @method('PATCH')
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label>Display Name <span class="required">*</span></label>
                                                        <input required class="form-control" name="name" type="text" value="{{ old('name', $user->name) }}" />
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Phone</label>
                                                        <input class="form-control" name="phone" type="text" value="{{ old('phone', $user->phone) }}" />
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>Email Address <span class="required">*</span></label>
                                                        <input required class="form-control" name="email" type="email" value="{{ old('email', $user->email) }}" />
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>Current Password <span class="required">*</span></label>
                                                        <input class="form-control" name="current_password" type="password" placeholder="Required only when setting a new password" autocomplete="current-password" />
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>New Password</label>
                                                        <input class="form-control" name="password" type="password" autocomplete="new-password" />
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Confirm Password</label>
                                                        <input class="form-control" name="password_confirmation" type="password" autocomplete="new-password" />
                                                    </div>
                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn btn-fill-out submit font-weight-bold" name="submit" value="Submit">Save Change</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-frontend>