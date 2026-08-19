<x-frontend>
    <main class="main pages">
        <div class="page-content pt-150 pb-150">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-6 col-md-12 m-auto">
                        <div class="login_wrap widget-taber-content background-white">
                            <div class="padding_eight_all bg-white">
                                <div class="heading_s1">
                                    <img class="border-radius-15" src="{{ asset('assets/imgs/page/forgot_password.svg') }}" alt="" />
                                    <h2 class="mb-15 mt-15">Forgot your password?</h2>
                                    <p class="mb-30">Not to worry, we got you! Let's get you a new password. Please enter your email address.</p>
                                </div>

                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email *" required autocomplete="email" autofocus class="@error('email') is-invalid @enderror" />
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-heading btn-block hover-up" name="login">Reset password</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-frontend>
