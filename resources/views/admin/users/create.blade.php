@extends('admin.layout.app')
@section('title','Add User')

@section('content')
<div class="card shadow-sm">
  <div class="card-header">
    <h5 class="mb-0">Add User</h5>
  </div>
  <div class="card-body">
    <form method="POST" action="{{ route('users.store') }}">
      @csrf
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="mb-3">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Role</label>
        <select name="role" class="form-select" required>
          <option value="user" {{ old('role')=='user'?'selected':'' }}>User</option>
          <option value="admin" {{ old('role')=='admin'?'selected':'' }}>Admin</option>
        </select>
        @error('role') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <div class="text-end">
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-success">Save</button>
      </div>
    </form>
  </div>
</div>
@endsection
