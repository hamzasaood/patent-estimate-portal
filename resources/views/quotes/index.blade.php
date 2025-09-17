@extends('layouts.app')
@section('title','My Quotes')

@section('content')
<div class="container py-5">

  {{-- Header --}}
  <div class="p-4 rounded shadow-sm mb-5" 
       style="background: linear-gradient(315deg, #4f708e, #2d3e50); color:#fff;">
    <h2 class="fw-bold mb-0" style="color:#fff;">My Quotes</h2>
    <p class="mb-0">Here you can find all your generated estimates/invoices.</p>
  </div>

  {{-- Quotes Table --}}
  <div class="card shadow-sm border-0">
    <div class="card-body">
      <table class="table table-striped align-middle">
        <thead style="background:#4f708e; color:#fff;">
          <tr>
            <th>#</th>
            <th>Service</th>
            <th>Region</th>
            <th>Date</th>
            <th>Total (USD)</th>
            <th>Status</th>
            <th class="text-end">Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($quotes as $quote)
            <tr>
              <td>{{ $quote->id }}</td>
              <td>{{ ucfirst(str_replace('_',' ',$quote->service)) }}</td>
              <td>{{ strtoupper($quote->region) }}</td>
              <td>{{ $quote->created_at->format('d M Y') }}</td>
              <td>
                @if($quote->is_white_label && $quote->total_with_firm)
                  ${{ number_format($quote->total_with_firm,2) }}
                @else
                  ${{ number_format($quote->total,2) }}
                @endif
              </td>
              <td>
                @if($quote->status === 'pending')
                  <span class="badge bg-warning text-dark">Pending</span>
                @elseif($quote->status === 'approved')
                  <span class="badge bg-success">Approved</span>
                @elseif($quote->status === 'rejected')
                  <span class="badge bg-danger">Rejected</span>
                @else
                  <span class="badge bg-secondary">Draft</span>
                @endif
              </td>
              <td class="text-end">
                <a href="{{ route('quotes.show.quick',$quote) }}" 
                   class="btn btn-sm btn-outline-primary">
                  View
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

      {{-- Pagination --}}
      <div class="mt-3">
        {{ $quotes->links() }}
      </div>
    </div>
  </div>
</div>
@endsection
