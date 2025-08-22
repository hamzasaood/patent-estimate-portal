@extends('layouts.app')
@section('title','Quote #'.$quote->id)

@section('content')
<div class="container">
  <h1 class="h3 fw-bold mb-4">Estimate #{{ $quote->id }}</h1>

  <div class="card shadow-sm mb-3">
    <div class="card-body">
      <p><strong>Application Type:</strong> {{ ucfirst($quote->application_type) }}</p>
      <p><strong>Jurisdiction:</strong> {{ strtoupper($quote->jurisdiction) }}</p>
      <p><strong>Application Number:</strong> {{ $quote->application_number ?? '-' }}</p>
      <p><strong>Claims:</strong> {{ $quote->claims }}</p>
      <p><strong>Pages:</strong> {{ $quote->pages }}</p>
      <p><strong>Drawings:</strong> {{ $quote->drawings }}</p>
    </div>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">
      <h5>Cost Breakdown</h5>
      <p>Base Fee: ${{ number_format($quote->base_fee) }}</p>
      <p>Extras: ${{ number_format($quote->extra_fee) }}</p>
      <p>Tax: ${{ number_format($quote->tax) }}</p>
      <hr>
      <h4>Total: ${{ number_format($quote->total) }}</h4>
    </div>
  </div>
</div>
@endsection
