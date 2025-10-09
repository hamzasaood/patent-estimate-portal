@extends('admin.layout.app')

@section('content')
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h2>Pricing Logics</h2>
        <a href="{{ route('pricing-logics.create') }}" class="btn btn-primary">+ Add New</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="table-responsive">
    <table class="table table-bordered" id="pricing">
        <thead class="table-dark">
            <tr>
                <th>Service</th>
                <th>Region</th>
                <th>Country</th>
                
                <th>Filing Fee</th>
                <th>Translation Fee</th>
                <th>Official Fee</th>
                
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logics as $logic)
                <tr>
                    <td>{{ $logic->service }}</td>
                    <td>{{ $logic->region }}</td>
                    <td>{{ $logic->country }}</td>
                    
                    <td>${{ number_format($logic->filing_fee,2) }}</td>
                    <td>${{ number_format($logic->translation_fee,2) }}</td>
                    <td>${{ number_format($logic->official_fee,2) }}</td>
                    <td>
                        <span class="badge {{ $logic->status ? 'bg-success':'bg-danger' }}">
                            {{ $logic->status ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('pricing-logics.edit', $logic) }}" class="btn btn-sm btn-warning">Edit</a>

<form action="{{ route('pricing-logics.destroy', $logic) }}" method="POST" class="d-inline"
      onsubmit="return confirm('Delete this?')">
    @csrf @method('DELETE')
    <button class="btn btn-sm btn-danger">Delete</button>
</form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>

    
</div>
<script>



</script>
@endsection
