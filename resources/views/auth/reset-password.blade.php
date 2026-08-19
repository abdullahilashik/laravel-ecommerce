<x-frontend>
    <main class="main pages">
        <div class="page-content pt-150 pb-150">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-8 col-md-12 m-auto">
                        <div class="row">
                            <div class="heading_s1">
                                <img class="border-radius-15" src="{{ asset('assets/imgs/page/reset_password.svg') }}" alt="" />
                                <h2 class="mb-15 mt-15">Set new password</h2>
                                <p class="mb-30">Please create a new password that you don't use on any other site.</p>
                            </div>
                            <div class="col-lg-6 col-md-8">
                                <div class="login_wrap widget-taber-content background-white">
                                    <div class="padding_eight_all bg-white">
                                        <form method="POST" action="{{ route('password.store') }}">
                                            @csrf
                                            <input type="hidden" name="token" value="{{ $request->route('token') }}">
                                            <div class="form-group">
                                                <input type="email" name="email" value="{{ old('email', $request->email) }}" placeholder="Email *" required autocomplete="email" autofocus class="@error('email') is-invalid @enderror" />
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="password" placeholder="Password *" required autocomplete="new-password" class="@error('password') is-invalid @enderror" />
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="password_confirmation" placeholder="Confirm password *" required autocomplete="new-password" />
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-heading btn-block hover-up" name="login">Reset password</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 pl-50">
                                <h6 class="mb-15">Password must:</h6>
                                <p>Be between 8 and 64 characters</p>
                                <p>Include at least two of the following:</p>
                                <ol class="list-insider">
                                    <li>An uppercase character</li>
                                    <li>A lowercase character</li>
                                    <li>A number</li>
                                    <li>A special character</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-frontend>
