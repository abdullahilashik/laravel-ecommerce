<div class="card">
    <div class="card-header">
        <h3 class="mb-0">Delete Account</h3>
    </div>
    <div class="card-body">
        <p class="mb-30">Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.</p>

        <button type="button" class="btn btn-fill-out submit font-weight-bold" data-bs-toggle="modal" data-bs-target="#confirm-user-deletion">{{ __('Delete Account') }}</button>
    </div>
</div>

<div class="modal fade custom-modal" id="confirm-user-deletion" tabindex="-1" aria-labelledby="confirm-user-deletion-label" aria-hidden="true" @if($errors->userDeletion->isNotEmpty()) data-bs-backdrop="static" data-bs-keyboard="false"@endif>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirm-user-deletion-label">Are you sure you want to delete your account?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-20">Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.</p>

                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="form-group">
                        <label>Password <span class="required">*</span></label>
                        <input class="form-control" name="password" type="password" placeholder="{{ __('Password') }}" />
                        @error('password', 'userDeletion')
                            <p class="text-danger font-sm mt-5 mb-0">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary mr-10" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-fill-out submit font-weight-bold">{{ __('Delete Account') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if($errors->userDeletion->isNotEmpty())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modal = new bootstrap.Modal(document.getElementById('confirm-user-deletion'));
            modal.show();
        });
    </script>
@endif