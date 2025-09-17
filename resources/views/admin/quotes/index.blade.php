@extends('admin.layout.app')

@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>

<div class="container-fluid p-4">
    <h3 class="mb-4">Quotes Management</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
    <div class="card shadow-sm">

        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                <thead class="table-light">
                    <tr>
                        <th>#ID</th>
                        <th>User</th>
                        <th>Service</th>
                        <th>Region</th>
                        <th>Title</th>
                        <th>Applicant</th>
                        <th>Total (USD)</th>
                        <th>White Label?</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th width="120">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($quotes as $quote)
                        <tr>
                            <td>{{ $quote->id }}</td>
                            <td>{{ $quote->user->name ?? 'Guest' }}</td>
                            <td>{{ ucfirst(str_replace('_',' ',$quote->service)) }}</td>
                            <td>{{ strtoupper($quote->region) }}</td>
                            <td>{{ $quote->title ?? '-' }}</td>
                            <td>{{ $quote->applicant ?? '-' }}</td>
                            <td>
                                <strong>${{ number_format($quote->is_white_label ? $quote->total_with_firm : $quote->total, 2) }}</strong>
                                @if($quote->is_white_label && $quote->firm_fees)
                                    <br><small class="text-muted">+Firm: ${{ number_format($quote->firm_fees,2) }}</small>
                                @endif
                            </td>
                            <td>
                                @if($quote->is_white_label)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge 
                                    @if($quote->status=='paid') bg-success 
                                    @elseif($quote->status=='pending') bg-warning 
                                    @elseif($quote->status=='quoted') bg-info 
                                    @else bg-dark @endif">
                                    {{ ucfirst($quote->status) }}
                                </span>
                            </td>
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
                    @empty
                        <tr>
                            <td colspan="11" class="text-center text-muted">No quotes found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            
        </div>
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
