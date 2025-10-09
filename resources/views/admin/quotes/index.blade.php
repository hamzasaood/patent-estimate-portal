@extends('admin.layout.app')

@section('content')

<div class="container">
    <h3 class="mb-4">Quotes Management</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    
        <div class="table-responsive">
            <table class="table table-hover " id="quotes">
                <thead class="table-dark">
                    <tr>
                        <th>#Group</th>
                        <th>User</th>
                        <th>Service</th>
                        <th>Regions</th>
                        
                        <th>Total (USD)</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th width="120">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($quotes as $quote)
                        <tr>
                            <td><span class="fw-bold text-primary">#{{ $quote->invoice_group }}</span></td>
                            <td>{{ $quote->user->name ?? 'Guest' }}</td>
                            <td>{{ ucfirst(str_replace('_',' ',$quote->service)) }}</td>
                            <td>{{ strtoupper($quote->regions) }}</td>
                           
                            <td>
                                <strong>
                                    ${{ number_format($quote->total_with_firm > 0 ? $quote->total_with_firm : $quote->total, 2) }}
                                </strong>
                            </td>
                            <td>
                                <span class="badge 
                                    @if($quote->status=='paid') bg-success 
                                    @elseif($quote->status=='pending_payment') bg-warning text-dark
                                    @elseif($quote->status=='quoted') bg-info 
                                    @else bg-secondary 
                                    @endif">
                                    {{ ucfirst($quote->status) }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($quote->created_at)->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('quotes.show', $quote->invoice_group) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <form action="{{ route('quotes.destroy', $quote->invoice_group) }}" method="POST" style="display:inline-block;">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Delete this group of quotes?')" class="btn btn-sm btn-outline-danger">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                No quotes found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    
</div>
@endsection
