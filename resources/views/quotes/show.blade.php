@extends('layouts.app')
@section('title','Quote #'.$quote->id)

@section('content')
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 fw-bold">Estimate #{{ $quote->id }}</h1>
    <a href="{{ route('quotes.download', $quote->id) }}" class="btn btn-danger">
      <i class="bi bi-file-earmark-pdf"></i> Download PDF
    </a>
  </div>

  {{-- White Label Logo (if available) --}}
  @if($quote->firm_logo)
    <div class="text-center mb-4">
      <img src="{{ asset($quote->firm_logo) }}" alt="Firm Logo" class="img-fluid" style="max-height: 80px;">
    </div>
  @endif

  <div class="card shadow-sm mb-3">
    <div class="card-body">
      <h5 class="fw-bold mb-3">Application Details</h5>
      <p><strong>Application Type:</strong> {{ ucfirst($quote->application_type) }}</p>
      <p><strong>Jurisdiction:</strong> {{ strtoupper($quote->jurisdiction) }}</p>
      <p><strong>Application Number:</strong> {{ $quote->application_number ?? '-' }}</p>
      <p><strong>Title:</strong> {{ $quote->title ?? '-' }}</p>
      <p><strong>Applicant:</strong> {{ $quote->applicant ?? '-' }}</p>
      <p><strong>Priority Date:</strong> {{ optional($quote->priority_date)->format('Y-m-d') ?? '-' }}</p>
      <p><strong>Filing Date:</strong> {{ optional($quote->filing_date)->format('Y-m-d') ?? '-' }}</p>
      <p><strong>Claims:</strong> {{ $quote->claims }}</p>
      <p><strong>Pages:</strong> {{ $quote->pages }}</p>
      <p><strong>Drawings:</strong> {{ $quote->drawings }}</p>
    </div>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">
      <h5 class="fw-bold mb-3">Cost Breakdown</h5>
      <p>Base Fee: ${{ number_format($quote->base_fee, 2) }}</p>
      <p>Extras: ${{ number_format($quote->extra_fee, 2) }}</p>
      <p>Tax: ${{ number_format($quote->tax, 2) }}</p>
      <hr>
      <h4>Total: ${{ number_format($quote->total, 2) }}</h4>
    </div>
  </div>
</div>
@endsection
