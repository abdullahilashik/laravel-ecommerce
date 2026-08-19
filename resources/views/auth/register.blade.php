<x-frontend>
    <main class="main pages">
        <div class="page-content pt-150 pb-150">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-lg-10 col-md-12 m-auto">
                        <div class="row">
                            <div class="col-lg-6 col-md-8">
                                <div class="login_wrap widget-taber-content background-white">
                                    <div class="padding_eight_all bg-white">
                                        <div class="heading_s1">
                                            <h1 class="mb-5">Create an Account</h1>
                                            <p class="mb-30">Already have an account? <a href="{{ route('login') }}">Login</a></p>
                                        </div>
                                        <form method="POST" action="{{ route('register') }}">
                                            @csrf
                                            <div class="form-group">
                                                <input type="text" name="name" value="{{ old('name') }}" placeholder="Name" required autofocus autocomplete="name" class="@error('name') is-invalid @enderror" />
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="username" class="@error('email') is-invalid @enderror" />
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="password" placeholder="Password" required autocomplete="new-password" class="@error('password') is-invalid @enderror" />
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="password_confirmation" placeholder="Confirm password" required autocomplete="new-password" />
                                            </div>
                                            <div class="form-group mb-30">
                                                <button type="submit" class="btn btn-heading btn-block hover-up" name="register">Submit &amp; Register</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 pr-30 d-none d-lg-block">
                                <div class="card-login mt-115">
                                    <a href="{{ route('social.redirect', 'facebook') }}" class="social-login facebook-login">
                                        <img src="{{ asset('assets/imgs/theme/icons/logo-facebook.svg') }}" alt="" />
                                        <span>Continue with Facebook</span>
                                    </a>
                                    <a href="{{ route('social.redirect', 'google') }}" class="social-login google-login">
                                        <img src="{{ asset('assets/imgs/theme/icons/logo-google.svg') }}" alt="" />
                                        <span>Continue with Google</span>
                                    </a>
                                    <a href="{{ route('social.redirect', 'apple') }}" class="social-login apple-login">
                                        <img src="{{ asset('assets/imgs/theme/icons/logo-apple.svg') }}" alt="" />
                                        <span>Continue with Apple</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-frontend>
