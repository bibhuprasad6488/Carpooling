@extends('admin.layouts.app')
@section('title', 'Profile Setting')
@section('content')
    <div class="container-fluid px-4">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="py-2">
                <h1 class="mt-4">Profile Setting</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item active">Profile Setting</li>
                </ol>
            </div>
            <div class="ms-auto d-none">
                <div class="btn-group">
                    <a href="#" class="btn btn-primary">Add New</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-user-cog me-1"></i>
                        Update Profile Information
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.profile.update') }}">
                            @csrf
                            @method('PATCH')

                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ isset($user) ? $user->name : '' }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ isset($user) ? $user->email : '' }}" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Password update form-->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-key me-1"></i>
                        Chnange Password
                    </div>
                    <div class="card-body">
                        <form method="POST" id="passworForm"
                            action="{{ route('admin.chnage.password', isset($user) ? $user->id : '') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="pass" class="form-label">Current Password</label>
                                <input type="password" class="form-control" id="current_password" name="current_password"
                                    value="">
                            </div>

                            <div class="mb-3">
                                <label for="text" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="newPass" name="new_password"
                                    value="">
                            </div>
                            <div class="mb-3">
                                <label for="text" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="confirmPass" name="confirm_password"
                                    value="">
                            </div>
                            <div id="errors"></div>

                            <button type="submit" class="btn btn-primary">Update Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('#passworForm').on('submit', function(e) {
            e.preventDefault();

            const form = $(this);
            const action = form.attr('action');

            const currPass = $('#current_password').val();
            const password = $('#newPass').val();
            const confirmPassword = $('#confirmPass').val();

            // Reset UI
            $('#newPass, #confirmPass, #current_password').css('border', '');
            $('#errors').html('');

            /* ---------- Validation ---------- */

            if (!currPass) {
                $('#current_password').css('border', '1px solid red');
                // toastr.error('Password must be at least 8 characters long.');
                $('#errors').html(
                    '<p class="text-danger">Current password is required.</p>');
                $('#newPass').val('');
                return;

            }
            if (password === currPass) {
                $('#newPass').css('border', '1px solid red');
                // toastr.error('Password must be at least 8 characters long.');
                $('#errors').html(
                    '<p class="text-danger">New Password must be different from current password.</p>');
                $('#newPass').val('');
                return;

            }

            if (!password || password.length < 8) {
                $('#newPass').css('border', '1px solid red');
                // toastr.error('Password must be at least 8 characters long.');
                $('#errors').html('<p class="text-danger">Password must be at least 8 characters long.</p>');
                return;
            }

            if (password !== confirmPassword) {
                $('#confirmPass').css('border', '1px solid red');
                // toastr.error('Passwords do not match.');
                $('#errors').html('<p class="text-danger">Passwords do not match.</p>');
                $('#confirmPass').val('');
                return;
            }
            // If validation passes  submit the form
            this.submit();

        });
    </script>
@endpush
