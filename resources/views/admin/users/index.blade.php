@extends('admin.layout.app')
@section('title','Manage Users')

@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>

<div class="d-flex justify-content-between mb-3">
    <h1 class="h4">Users</h1>
    <a href="{{ route('users.create') }}" class="btn btn-primary">Add User</a>
</div>

<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
<div class="table-responsive">
<table class="table table-bordered table-striped" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
  <thead class="table-light">
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Email</th>
      <th>Role</th>
      <th>Pricing Level PF</th>
      <th>Pricing Level TF</th>
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
      <td>{{ $user->pfLevel->name .' / ' .$user->pfLevel->adjustment_percent . '%'  }}</td>
      <td>{{ $user->tfLevel->name .' / ' .$user->tfLevel->adjustment_percent . '%'  }}</td>
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
</div>
</div>
<script>



    $(document).ready(function() {
        $('#DataTables_Table_0').DataTable();
        searching: true
    });

    

</script>

@endsection
