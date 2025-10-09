@extends('layouts.app')
@section('title','My Quotes')

@section('content')


<div class="container py-5">

  {{-- Portal Header --}}
  <div class="p-4 rounded shadow-sm mb-5" 
       style="background: linear-gradient(315deg, #4f708e, #2d3e50); color:#fff;">
    <h2 class="fw-bold mb-1" style="color:#fff;">📑 My Quotes</h2>
    <p class="mb-0">Here you can view, download and manage all your estimates and invoices.</p>
  </div>

  {{-- Quotes Table --}}
  <div class="card shadow-sm border-0">
    <div class="card-body">
      <div class="table-responsive">
      <table id="quotesTable" class="table table-striped table-hover align-middle w-100">
        <thead style="background:#4f708e; color:#fff;">
          <tr>
            <th>#</th>
            <th>Service</th>
            <th>Regions</th>
            <th>Date</th>
            <th>Total (USD)</th>
            <th>Status</th>
            <th class="text-end">Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($quotes as $quote)
            <tr>
              <td>{{ $quote->invoice_group }}</td>
              <td>{{ ucfirst(str_replace('_',' ',$quote->service)) }}</td>
              <td>
                @if(isset($quote->regions))
                  {{ collect(explode(',', $quote->regions))->map(fn($r) => strtoupper(trim($r)))->join(', ') }}
                @endif
              </td>
              <td>{{ \Carbon\Carbon::parse($quote->created_at)->format('d M Y') }}</td>
              <td>
                @if($quote->is_white_label && $quote->total_with_firm)
                  ${{ number_format($quote->total_with_firm,2) }}
                @else
                  ${{ number_format($quote->total,2) }}
                @endif
              </td>
              <td>
                @if($quote->status === 'quoted')
                  <span class="badge bg-warning text-dark">Quoted</span>
                @elseif($quote->status === 'paid')
                  <span class="badge bg-success">Paid</span>
                @elseif($quote->status === 'pending_payment')
                  <span class="badge bg-danger">Pending Payment</span>
                @else
                  <span class="badge bg-secondary">Draft</span>
                @endif
              </td>
              <td class="text-end">
                <a href="{{ route('quotes.show.quick',$quote->invoice_group) }}" 
                   class="btn btn-sm btn-outline-primary">
                  <i class="bi bi-eye"></i> View
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center text-muted py-4">
                No quotes found.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    </div>
  </div>
</div>










 {{-- jQuery + DataTables --}}
  

  {{-- DataTables Init --}}
 



  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endsection


 

