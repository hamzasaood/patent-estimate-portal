@extends('admin.layout.app')

@section('content')
<div class="container-fluid p-4">
    <h3>Pricing Logic Rules</h3>
    <a href="{{ route('pricing.create') }}" class="btn btn-primary mb-3">+ Add New Rule</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Jurisdiction</th>
                <th>Type</th>
                <th>Base Fee</th>
                <th>Tax %</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rules as $rule)
            <tr>
                <td>{{ $rule->id }}</td>
                <td>{{ $rule->jurisdiction }}</td>
                <td>{{ $rule->application_type }}</td>
                <td>{{ $rule->base_fee }}</td>
                <td>{{ $rule->tax_percentage }}</td>
                <td>
                    <span class="badge bg-{{ $rule->status == 'active' ? 'success':'secondary' }}">
                        {{ ucfirst($rule->status) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('pricing.edit',$rule->id) }}" class="btn btn-sm btn-info">Edit</a>
                    <form action="{{ route('pricing.destroy',$rule->id) }}" method="POST" style="display:inline-block;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this rule?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $rules->links() }}
</div>
@endsection
