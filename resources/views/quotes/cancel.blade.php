@extends('layouts.app')
@section('title','Payment Cancelled')

@section('content')
<div class="container text-center my-5">
  <h1 class="text-danger">❌ Payment Cancelled</h1>
  <p>Your quote #{{ $quote->id }} was not paid. You can try again.</p>
  <a href="{{ route('quotes.show.quick', $quote) }}" class="btn btn-secondary">Back to Quote</a>
</div>
@endsection
