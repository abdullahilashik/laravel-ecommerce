<div class="card mb-4">
    <div class="card-header">
        <h3 class="mb-0">Profile Information</h3>
    </div>
    <div class="card-body">
        <p class="mb-30">Update your account's profile information and email address.</p>

        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <form method="post" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            <div class="form-group">
                <label>Name <span class="required">*</span></label>
                <input required class="form-control" name="name" type="text" autocomplete="name" value="{{ old('name', $user->name) }}" />
            </div>

            <div class="form-group">
                <label>Email Address <span class="required">*</span></label>
                <input required class="form-control" name="email" type="email" autocomplete="username" value="{{ old('email', $user->email) }}" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-2">
                        <p class="mb-5">
                            {{ __('Your email address is unverified.') }}
                            <button form="send-verification" class="btn btn-sm btn-fill-out">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mb-5 text-success">{{ __('A new verification link has been sent to your email address.') }}</p>
                        @endif
                    </div>
                @endif
            </div>

            <div class="form-group mb-0 d-flex align-items-center">
                <button type="submit" class="btn btn-fill-out submit font-weight-bold">{{ __('Save') }}</button>

                @if (session('status') === 'profile-updated')
                    <span class="text-success ml-30">{{ __('Saved.') }}</span>
                @endif
            </div>
        </form>
    </div>
</div>