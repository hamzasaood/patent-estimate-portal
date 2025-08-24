@extends('admin.layout.app')
@section('title','Manage Users')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1 class="h4">Users</h1>
    <a href="{{ route('users.create') }}" class="btn btn-primary">Add User</a>
</div>

<table class="table table-bordered">
  <thead class="table-light">
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Email</th>
      <th>Role</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach($users as $user)
    <tr>
      <td>{{ $user->id }}</td>
      <td>{{ $user->name }}</td>
      <td>{{ $user->email }}</td>
      <td><span class="badge bg-{{ $user->role=='admin'?'danger':'secondary' }}">{{ ucfirst($user->role) }}</span></td>
      <td>
        <a href="{{ route('users.edit',$user) }}" class="btn btn-sm btn-warning">Edit</a>
        <form action="{{ route('users.destroy',$user) }}" method="POST" class="d-inline">
          @csrf @method('DELETE')
          <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this user?')">Delete</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

{{ $users->links() }}
@endsection
