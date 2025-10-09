@extends('layouts.app')
@section('title','Payment Successful')

@section('content')
<div class="container text-center my-5">
  <h1 class="text-success">✅ Payment Successful!</h1>

  <p>Your invoice group <strong>#{{ $groupId }}</strong> has been paid.</p>

  <p class="mt-3">
    Grand Total Paid: <strong>${{ number_format($grandTotal, 2) }}</strong>
  </p>

  <a href="{{ route('quotes.show.quick', $groupId) }}" class="btn btn-primary">
    View Invoice
  </a>
</div>
@endsection

