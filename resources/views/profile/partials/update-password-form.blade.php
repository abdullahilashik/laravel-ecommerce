<div class="card mb-4">
    <div class="card-header">
        <h3 class="mb-0">Update Password</h3>
    </div>
    <div class="card-body">
        <p class="mb-30">Ensure your account is using a long, random password to stay secure.</p>

        <form method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <div class="form-group">
                <label>Current Password <span class="required">*</span></label>
                <input class="form-control" name="current_password" type="password" autocomplete="current-password" />
                @error('current_password', 'updatePassword')
                    <p class="text-danger font-sm mt-5 mb-0">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label>New Password <span class="required">*</span></label>
                <input class="form-control" name="password" type="password" autocomplete="new-password" />
                @error('password', 'updatePassword')
                    <p class="text-danger font-sm mt-5 mb-0">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label>Confirm Password <span class="required">*</span></label>
                <input class="form-control" name="password_confirmation" type="password" autocomplete="new-password" />
                @error('password_confirmation', 'updatePassword')
                    <p class="text-danger font-sm mt-5 mb-0">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mb-0 d-flex align-items-center">
                <button type="submit" class="btn btn-fill-out submit font-weight-bold">{{ __('Save') }}</button>

                @if (session('status') === 'password-updated')
                    <span class="text-success ml-30">{{ __('Saved.') }}</span>
                @endif
            </div>
        </form>
    </div>
</div>