@extends('admin.layout.app')

@section('content')
<div class="container-fluid p-4">
    <h3 class="mb-4">Quotes Management</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>User</th>
                        <th>Application Type</th>
                        <th>Jurisdiction</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quotes as $quote)
                    <tr>
                        <td>{{ $quote->id }}</td>
                        <td>{{ $quote->user->name ?? 'Guest' }}</td>
                        <td>{{ $quote->application_type }}</td>
                        <td>{{ $quote->jurisdiction }}</td>
                        <td>{{ number_format($quote->total,2) }}</td>
                        <td><span class="badge bg-info">{{ ucfirst($quote->status) }}</span></td>
                        <td>{{ $quote->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('quotes.show',$quote->id) }}" class="btn btn-sm btn-primary">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <form action="{{ route('quotes.destroy',$quote->id) }}" method="POST" style="display:inline-block;">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this quote?')" class="btn btn-sm btn-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-3">
                {{ $quotes->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
