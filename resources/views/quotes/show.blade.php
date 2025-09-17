@extends('layouts.app')
@section('title','Quote #'.$quote->id)

@section('content')
<div class="container py-5">

  {{-- Header --}}
  <div class="p-4 rounded shadow-sm mb-5" 
       style="background: linear-gradient(315deg, #4f708e, #2d3e50); color:#fff;">
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <h2 class="fw-bold mb-1" style="color: #fff;">Estimate / Invoice</h2>
        <p class="mb-0">Quote #{{ $quote->id }} • {{ $quote->created_at->format('d M Y') }}</p>
      </div>
      <div>
        @if($quote->firm_logo)
          <img src="{{ asset($quote->firm_logo) }}" alt="Firm Logo" style="max-height:70px;">
        @else
          <img src="{{ asset('images/emuna-logo.png') }}" alt="Emuna IP Logo" style="max-height:70px;">
        @endif
      </div>
    </div>
  </div>

  {{-- Applicant + Service Info --}}
  <div class="row g-4 mb-4">
    <div class="col-md-6">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
          <h6 class="text-uppercase fw-bold mb-3" style="color:#4f708e;">Applicant Details</h6>
          <p><strong>{{ $quote->applicant ?? '-' }}</strong></p>
          <p class="mb-1">Title: {{ $quote->title ?? '-' }}</p>
          <p class="mb-1">Application #: {{ $quote->application_number ?? '-' }}</p>
          <p class="mb-1">Reference #: {{ $quote->reference_number ?? '-' }}</p>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
          <h6 class="text-uppercase fw-bold mb-3" style="color:#4f708e;">Service Info</h6>
          <p class="mb-1"><strong>{{ ucfirst(str_replace('_',' ',$quote->service)) }}</strong></p>
          <p class="mb-1">Region: {{ strtoupper($quote->region) }}</p>
          <p class="mb-1">Priority Date: {{ optional($quote->priority_date)->format('d M Y') ?? '-' }}</p>
          <p class="mb-1">Filing Date: {{ optional($quote->filing_date)->format('d M Y') ?? '-' }}</p>
        </div>
      </div>
    </div>
  </div>

  {{-- Cost Breakdown --}}
  <div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
      <h6 class="text-uppercase fw-bold mb-3" style="color:#4f708e;">Cost Breakdown</h6>
      <table class="table table-striped align-middle">
        <thead style="background:#4f708e; color:#fff;">
          <tr>
            <th>Description</th>
            <th class="text-end">Amount (USD)</th>
          </tr>
        </thead>
        <tbody>
          <tr><td>Filing Fee</td><td class="text-end">${{ number_format($quote->filing_fee,2) }}</td></tr>
          <tr><td>Translation Fee</td><td class="text-end">${{ number_format($quote->translation_fee,2) }}</td></tr>
          <tr><td>Official Fee</td><td class="text-end">${{ number_format($quote->official_fee,2) }}</td></tr>
          <tr><td>Extra Fees</td><td class="text-end">${{ number_format($quote->extra_fee,2) }}</td></tr>
          <tr><td>Tax</td><td class="text-end">${{ number_format($quote->tax,2) }}</td></tr>
          @if($quote->is_white_label && $quote->firm_fees)
          <tr><td>Firm Fees</td><td class="text-end">${{ number_format($quote->firm_fees,2) }}</td></tr>
          @endif
        </tbody>
      </table>

      {{-- Total Highlight --}}
      <div class="p-3 rounded mt-3 fw-bold fs-5 text-end text-white" 
           style="background:#2d3e50;">
        Total: 
        @if($quote->is_white_label && $quote->total_with_firm)
          ${{ number_format($quote->total_with_firm,2) }}
        @else
          ${{ number_format($quote->total,2) }}
        @endif
      </div>
    </div>
  </div>

  {{-- Special Instructions --}}
  @if($quote->special_instructions)
  <div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
      <h6 class="text-uppercase fw-bold mb-3" style="color:#4f708e;">Special Instructions</h6>
      <p>{{ $quote->special_instructions }}</p>
    </div>
  </div>
  @endif

  {{-- Attachment --}}
  @if($quote->attachment)
  <div class="mb-4">
    <a href="{{ asset($quote->attachment) }}" target="_blank" class="btn btn-outline-dark">
      📎 View / Download Attachment
    </a>
  </div>
  @endif

  {{-- Footer --}}
  <div class="text-center text-muted mt-5" style="font-size:0.9em;">
    Thank you for working with <span style="color:#4f708e;">Emuna IP</span>.<br>
    This is a system-generated estimate and may be subject to adjustments.
  </div>

  {{-- PDF Button --}}
  <div class="text-end mt-4">
    <a href="{{ route('quotes.download', $quote->id) }}" class="btn btn-danger px-4">
      <i class="bi bi-file-earmark-pdf"></i> Download PDF
    </a>
  </div>

</div>
@endsection
