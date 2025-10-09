@extends('admin.layout.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">⚙️ Admin Settings</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Name</label>
                            <input type="text" name="name" value="{{ old('name', $admin->name) }}"
                                   class="form-control @error('name') is-invalid @enderror">
                            @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" value="{{ old('email', $admin->email) }}"
                                   class="form-control @error('email') is-invalid @enderror">
                            @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <hr>

                        <div class="mb-3">
                            <label class="form-label fw-bold">New Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                            @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            <small class="text-muted">Leave blank if you don’t want to change password</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary px-4">💾 Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
