@extends('admin.layout.app')

@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Pricing Levels</h2>
        <a href="{{ route('pricing-levels.create') }}" class="btn btn-primary">+ Add New</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
<div class="table-responsive">
    <table class="table table-bordered table-striped" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Kind/type</th>
                <th>Adjustment %</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($levels as $level)
                <tr>
                    <td>{{ $level->id }}</td>
                    <td>{{ $level->name }}</td>
                    <td>{{ $level->kind  }}</td>
                    <td>{{ $level->adjustment_percent }}%</td>
                    <td>
                        <a href="{{ route('pricing-levels.edit',$level) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('pricing-levels.destroy',$level) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Are you sure?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger delete-button">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
</div>

    
</div>
<script>



    $(document).ready(function() {
        $('#DataTables_Table_0').DataTable();
        searching: true
    });

    

</script>
@endsection
