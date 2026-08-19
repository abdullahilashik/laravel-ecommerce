<x-frontend>
    <main class="main pages">
        <div class="page-content pt-150 pb-150">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-lg-10 col-md-12 m-auto">
                        <div class="row">
                            <div class="col-lg-6 pr-30 d-none d-lg-block">
                                <img class="border-radius-15" src="{{ asset('assets/imgs/page/login-1.png') }}" alt="" />
                            </div>
                            <div class="col-lg-6 col-md-8">
                                <div class="login_wrap widget-taber-content background-white">
                                    <div class="padding_eight_all bg-white">
                                        <div class="heading_s1">
                                            <h1 class="mb-5">Login</h1>
                                            <p class="mb-30">Don't have an account? <a href="{{ route('register') }}">Create here</a></p>
                                        </div>

                                        @if (session('status'))
                                            <div class="alert alert-success" role="alert">
                                                {{ session('status') }}
                                            </div>
                                        @endif

                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf
                                            <div class="form-group">
                                                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email *" required autofocus autocomplete="username" class="@error('email') is-invalid @enderror" />
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="password" placeholder="Password *" required autocomplete="current-password" class="@error('password') is-invalid @enderror" />
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="login_footer form-group mb-50">
                                                <div class="chek-form">
                                                    <div class="custome-checkbox">
                                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />
                                                        <label class="form-check-label" for="remember"><span>Remember me</span></label>
                                                    </div>
                                                </div>
                                                @if (Route::has('password.request'))
                                                    <a class="text-muted" href="{{ route('password.request') }}">Forgot password?</a>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-heading btn-block hover-up" name="login">Log in</button>
                                            </div>
                                        </form>
                                        <div class="divider-text-center mt-30 mb-30">
                                            <span>or</span>
                                        </div>
                                        <div class="text-center">
                                            <a href="{{ route('social.redirect', 'facebook') }}" class="btn btn-facebook btn-block hover-up mb-10">
                                                <i class="fi-rs-facebook mr-10"></i> Continue with Facebook
                                            </a>
                                            <a href="{{ route('social.redirect', 'google') }}" class="btn btn-google btn-block hover-up mb-10">
                                                <i class="fi-rs-google mr-10"></i> Continue with Google
                                            </a>
                                            <a href="{{ route('social.redirect', 'apple') }}" class="btn btn-apple btn-block hover-up">
                                                <i class="fi-rs-apple mr-10"></i> Continue with Apple
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-frontend>
